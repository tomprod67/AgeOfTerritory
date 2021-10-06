<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrainingUnitRepository;
use App\Entity\TrainingUnit;
use App\Entity\Isle;


/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class UnitController extends AbstractController
{

    /**
     * @Route("/game/unit", name="game_unit")
     * @param TrainingUnitRepository $trainingUnitRepository
     * @return Response
     */
    public function unit(TrainingUnitRepository $trainingUnitRepository): Response
    {
        $isle = $this->getUser()->getMainIsle();
        return $this->render('game/unit/unit.html.twig',
            [
                'units' => $trainingUnitRepository->getAllUnitsByIsle($isle)
            ]
        );
    }

    /**
     * @Route("game/unit/show/{id}", name="game_unit_show", methods={"GET"})
     * @param TrainingUnit $unit
     * @return RedirectResponse|Response
     */
    public function showUnit(TrainingUnit $unit)
    {
        if ($this->checkUserIsle($unit->getIsle())) {
            return $this->render('game/unit/show_unit.html.twig', [
                'unit' => $unit
            ]);
        }
        return $this->redirectToRoute('game_unit');
    }

    /**
     * @Route("/game/unit/training/timer-start/{id_unit}", name="game_unit_training_start")
     * @param $id_unit
     * @param ObjectManager $manager
     * @param Request $request
     * @return null|RedirectResponse
     */
    public function trainingUnit($id_unit, ObjectManager $manager, Request $request): ?RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $unit = $manager->getRepository(TrainingUnit::class)->find($id_unit);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        // On vérifie que le joueur a assez de ressource pour construire le batiment
        if ($request->request->has('number') && $request->request->get('number') >= 1) {
            $number = $request->request->get('number');
            if ($isle->getWoodStock() >= ($unit->getWoodCost() * $number) && $isle->getStoneStock() >= ($unit->getStoneCost() * $number)
                && $isle->getMetalStock() >= ($unit->getMetalCost() * $number)) {

                // On calcul combien on doit rendre a l'utilisateur
                $resteOfWood = str_replace(' ', '',$session->get('wood')) - ($unit->getWoodCost() * $number);
                $resteOfStone = str_replace(' ', '',$session->get('stone')) - ($unit->getStoneCost() * $number);
                $resteOfMetal = str_replace(' ', '',$session->get('metal')) - ($unit->getMetalCost() * $number);

                // On rend a l'utilisateur
                $isle->setWoodStock($resteOfWood);
                $isle->setStoneStock($resteOfStone);
                $isle->setMetalStock($resteOfMetal);

                $unit->setNbTemp($number);
                $startDate = time();
                $unit->setStartDate($startDate);
                $trainingTime = $unit->getTrainingTime() * $number;
                $unit->setEndDate($startDate + $trainingTime);

                // On persist et on flush les données
                $entityManager->persist($unit);
                $entityManager->persist($isle);
                $entityManager->flush();

                $session->set('wood', $isle->getWoodStock());
                $session->set('stone', $isle->getStoneStock());
                $session->set('metal', $isle->getMetalStock());

                return $this->redirectToRoute('game_unit');
            }

            $this->addFlash('error', 'Vous n\'avez pas assez de ressources pour construire ce nombre de d\'unité(s)');
            return $this->redirectToRoute('game_unit');
        }

        $this->addFlash('error', 'Il faut entrer un nombre entier dans ce champ ! Reesayer');
        return $this->redirectToRoute('game_unit');
    }

    /**
     * @Route("/game/unit/training/timer-end/{id_unit}", name="game_unit_training_end")
     * @param $id_unit
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function updateUnitAfterTimer($id_unit, ObjectManager $manager): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $unit = $manager->getRepository(TrainingUnit::class)->find($id_unit);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $number = $unit->getNbTemp();

        $totalCost = (($unit->getWoodCost() * $number) + ($unit->getStoneCost() * $number) + ($unit->getMetalCost() * $number));
        $powerPoint = $unit->upPowerPoint($totalCost);

        $unit->setNombre($unit->getNombre() + $number);
        $unit->setEndDate(null);
        $unit->setStartDate(null);
        $unit->setNbTemp(null);

        $actualPowerPoint = $isle->getPowerPoint();
        $isle->setPowerPoint($actualPowerPoint + $powerPoint);

        // On persist et on flush les données
        $entityManager->persist($isle);
        $entityManager->persist($unit);
        $entityManager->flush();

        return $this->redirectToRoute('game_unit');
    }

    /**
     * @Route("/game/unit/cancel/{id_unit}", name="game_unit_cancel")
     * @param $id_unit
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function cancelUnit($id_unit, ObjectManager $manager, Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $unit = $manager->getRepository(TrainingUnit::class)->find($id_unit);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $number = $unit->getNbTemp();

        $restOfWood = ($unit->getWoodCost() * $number) / 2;
        $restOfStone = ($unit->getStoneCost() * $number) / 2;
        $restOfMetal = ($unit->getMetalCost() * $number) / 2;

        $isle->setWoodStock(str_replace(' ', '', $session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $unit->setNbTemp(null);
        $unit->setEndDate(null);
        $unit->setStartDate(null);

        $entityManager->persist($isle);
        $entityManager->persist($unit);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_unit');
    }


    public function checkUserIsle(Isle $isle): bool
    {
        return !($this->getUser() !== $isle->getUser());
    }
}