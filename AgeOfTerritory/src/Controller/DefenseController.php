<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BuildDefenseRepository;
use App\Entity\BuildDefense;
use App\Entity\Isle;


/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class DefenseController extends AbstractController
{
    /**
     * @Route("/game/defense", name="game_defense")
     * @param BuildDefenseRepository $buildDefenseRepository
     * @return Response
     *
     * Cette function affiche la liste des défenses de l'île
     */
    public function defense(BuildDefenseRepository $buildDefenseRepository): Response
    {
        $isle = $this->getUser()->getMainIsle();
        return $this->render('game/defense/defense.html.twig',
            [
                'defenses' => $buildDefenseRepository->getAllDefensesByIsle($isle)
            ]
        );
    }

    /**
     * @Route("game/defense/show/{id}", name="game_defense_show", methods={"GET"})
     * @param BuildDefense $defense
     * @return RedirectResponse|Response
     *
     * Cette function affiche une defense grace a son id
     */
    public function showDefense(BuildDefense $defense)
    {
        if ($this->checkUserIsle($defense->getIsle())) {
            return $this->render('game/defense/show.html.twig',
                [
                    'defense' => $defense
                ]
            );
        }
        return $this->redirectToRoute('game_defense');
    }

    /**
     * @Route("/game/defense/build/timer-start/{id_defense}", name="game_defense_build_start")
     * @param $id_defense
     * @param ObjectManager $manager
     * @param Request $request
     * @return null|RedirectResponse
     *
     * Cette function permet d'initialiser le timer de contruction
     */
    public function buildDefense($id_defense, ObjectManager $manager, Request $request): ?RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $defense = $manager->getRepository(BuildDefense::class)->find($id_defense);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        // On vérifie que le joueur a assez de ressource pour construire le batiment
        if ($request->request->has('number') && $request->request->get('number') >= 1) {
            $number = $request->request->get('number');
            if ($isle->getWoodStock() >= ($defense->getWoodCost() * $number) && $isle->getStoneStock() >= ($defense->getStoneCost() * $number)
                && $isle->getMetalStock() >= ($defense->getMetalCost() * $number)) {

                // On calcul combien on doit rendre a l'utilisateur
                $resteOfWood = str_replace(' ', '',$session->get('wood')) - ($defense->getWoodCost() * $number);
                $resteOfStone = str_replace(' ', '',$session->get('stone')) - ($defense->getStoneCost() * $number);
                $resteOfMetal = str_replace(' ', '',$session->get('metal')) - ($defense->getMetalCost() * $number);


                // On rend a l'utilisateur
                $isle->setWoodStock($resteOfWood);
                $isle->setStoneStock($resteOfStone);
                $isle->setMetalStock($resteOfMetal);


                $defense->setNbTemp($number);
                $startDate = time();
                $defense->setStartDate($startDate);
                $buildTime = $defense->getBuildTime() * $number;
                $defense->setEndDate($startDate + $buildTime);

                // On persist et on flush les données
                $entityManager->persist($defense);
                $entityManager->persist($isle);
                $entityManager->flush();

                $session->set('wood', $isle->getWoodStock());
                $session->set('stone', $isle->getStoneStock());
                $session->set('metal', $isle->getMetalStock());

                return $this->redirectToRoute('game_defense');
            }

            $this->addFlash('error', 'Vous n\avez pas assez de ressources pour construire ce nombre de défense(s)');
            return $this->redirectToRoute('game_defense');
        }

        $this->addFlash('error', 'Il faut entrer un nombre entier dans ce champ ! Reesayer');
        return $this->redirectToRoute('game_defense');
    }


    /**
     * @Route("/game/defense/build/timer-end/{id_defense}", name="game_defense_build_end")
     * @param $id_defense
     * @param ObjectManager $manager
     * @return RedirectResponse
     *
     * Cette function met a jour les infos a la fin du timer de construction
     */
    public function updateDefAfterTimer(GameController $game, $id_defense, ObjectManager $manager): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $defense = $manager->getRepository(BuildDefense::class)->find($id_defense);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $number = $defense->getNbTemp();

        $totalCost = (($defense->getWoodCost() * $number) + ($defense->getStoneCost() * $number) + ($defense->getMetalCost() * $number));
        $powerPoint = $game->upPowerPoint($totalCost);

        $defense->setNombre($defense->getNombre() + $number);
        $defense->setEndDate(null);
        $defense->setStartDate(null);
        $defense->setNbTemp(null);

        $actualPowerPoint = $isle->getPowerPoint();
        $isle->setPowerPoint($actualPowerPoint + $powerPoint);

        // On persist et on flush les données
        $entityManager->persist($isle);
        $entityManager->persist($defense);
        $entityManager->flush();

        return $this->redirectToRoute('game_defense');
    }

    /**
     * @Route("/game/defense/cancel/{id_defense}", name="game_defense_cancel")
     * @param $id_defense
     * @param ObjectManager $manager
     * @return RedirectResponse
     *
     * Cette function permet d'annuler la construction en cours.
     */
    public function cancelDef($id_defense, ObjectManager $manager, Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $defense = $manager->getRepository(BuildDefense::class)->find($id_defense);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $number = $defense->getNbTemp();

        $restOfWood = ($defense->getWoodCost() * $number) / 2;
        $restOfStone = ($defense->getStoneCost() * $number) / 2;
        $restOfMetal = ($defense->getMetalCost() * $number) / 2;

        $isle->setWoodStock(str_replace(' ', '', $session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $defense->setNbTemp(null);

        $defense->setEndDate(null);
        $defense->setStartDate(null);

        $entityManager->persist($isle);
        $entityManager->persist($defense);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_defense');

    }
    public function checkUserIsle(Isle $isle): bool
    {
        return !($this->getUser() !== $isle->getUser());
    }
}