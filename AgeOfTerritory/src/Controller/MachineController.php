<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrainingMachineRepository;
use App\Entity\TrainingMachine;
use App\Entity\Isle;


/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class MachineController extends AbstractController
{

    /**
     * @Route("/game/machine", name="game_machine")
     * @param TrainingMachineRepository $trainingMachineRepository
     * @return Response
     */
    public function machine(TrainingMachineRepository $trainingMachineRepository): Response
    {
        $isle = $this->getUser()->getMainIsle();
        return $this->render('game/machine/machine.html.twig',
            [
                'machines' => $trainingMachineRepository->getAllMachinesByIsle($isle)
            ]
        );
    }

    /**
     * @Route("game/machine/show/{id}", name="game_machine_show", methods={"GET"})
     * @param TrainingMachine $machine
     * @return RedirectResponse|Response
     */
    public function showMachine(TrainingMachine $machine)
    {
        if ($this->checkUserIsle($machine->getIsle())) {
            return $this->render('game/machine/show_machine.html.twig',
                [
                    'machine' => $machine
                ]
            );
        }
        return $this->redirectToRoute('game_machine');
    }

    /**
     * @Route("/game/machine/training/timer-start/{id_machine}", name="game_machine_training_start")
     * @param $id_machine
     * @param ObjectManager $manager
     * @param Request $request
     * @return null|RedirectResponse
     */
    public function trainingMachine($id_machine, ObjectManager $manager, Request $request): ?RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $machine = $manager->getRepository(TrainingMachine::class)->find($id_machine);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        // On vérifie que le joueur a assez de ressource pour construire le batiment
        if ($request->request->has('number') && $request->request->get('number') >= 1) {

            $number = $request->request->get('number');
            if ($isle->getWoodStock() >= ($machine->getWoodCost() * $number) && $isle->getStoneStock() >= ($machine->getStoneCost() * $number)
                && $isle->getMetalStock() >= ($machine->getMetalCost() * $number)) {

                $resteOfWood = str_replace(' ', '',$session->get('wood')) - ($machine->getWoodCost() * $number);
                $resteOfStone = str_replace(' ', '',$session->get('stone')) - ($machine->getStoneCost() * $number);
                $resteOfMetal = str_replace(' ', '',$session->get('metal')) - ($machine->getMetalCost() * $number);

                // On rend a l'utilisateur
                $isle->setWoodStock($resteOfWood);
                $isle->setStoneStock($resteOfStone);
                $isle->setMetalStock($resteOfMetal);

                $machine->setNbTemp($number);
                $startDate = time();
                $machine->setStartDate($startDate);
                $trainingTime = $machine->getTrainingTime() * $number;
                $machine->setEndDate($startDate + $trainingTime);

                // On persist et on flush les données
                $entityManager->persist($machine);
                $entityManager->persist($isle);
                $entityManager->flush();

                $session->set('wood', $isle->getWoodStock());
                $session->set('stone', $isle->getStoneStock());
                $session->set('metal', $isle->getMetalStock());

                return $this->redirectToRoute('game_machine');
            }

            $this->addFlash('error', 'Vous n\avez pas assez de ressources pour construire ce nombre de de machine(s)');
            return $this->redirectToRoute('game_machine');
        }

        $this->addFlash('error', 'Il faut entrer un nombre entier dans ce champ ! Reesayer');
        return $this->redirectToRoute('game_machine');
    }

    /**
     * @Route("/game/machine/training/timer-end/{id_machine}", name="game_machine_training_end")
     * @param $id_machine
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function updateMachineAfterTimer($id_machine, ObjectManager $manager): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $machine = $manager->getRepository(TrainingMachine::class)->find($id_machine);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $number = $machine->getNbTemp();


        $totalCost = (($machine->getWoodCost() * $number) + ($machine->getStoneCost() * $number) + ($machine->getMetalCost() * $number));
        $powerPoint = $machine->upPowerPoint($totalCost);

        $machine->setNombre($machine->getNombre() + $number);
        $machine->setEndDate(null);
        $machine->setStartDate(null);
        $machine->setNbTemp(null);

        $actualPowerPoint = $isle->getPowerPoint();
        $isle->setPowerPoint($actualPowerPoint + $powerPoint);

        // On persist et on flush les données
        $entityManager->persist($isle);
        $entityManager->persist($machine);
        $entityManager->flush();

        return $this->redirectToRoute('game_machine');
    }

    /**
     * @Route("/game/machine/cancel/{id_machine}", name="game_machine_cancel")
     * @param $id_machine
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function cancelMachine(Request $request, $id_machine, ObjectManager $manager): RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $machine = $manager->getRepository(TrainingMachine::class)->find($id_machine);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $number = $machine->getNbTemp();

        $restOfWood = ($machine->getWoodCost() * $number) / 2;
        $restOfStone = ($machine->getStoneCost() * $number) / 2;
        $restOfMetal = ($machine->getMetalCost() * $number) / 2;

        $isle->setWoodStock(str_replace(' ', '', $session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $machine->setNbTemp(null);
        $machine->setEndDate(null);
        $machine->setStartDate(null);

        $entityManager->persist($isle);
        $entityManager->persist($machine);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_machine');

    }

    public function checkUserIsle(Isle $isle): bool
    {
        return !($this->getUser() !== $isle->getUser());
    }
}