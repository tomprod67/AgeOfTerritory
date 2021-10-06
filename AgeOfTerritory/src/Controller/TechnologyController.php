<?php

namespace App\Controller;


use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SearchTechnologyRepository;
use App\Entity\SearchTechnology;
use App\Entity\Isle;


/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class TechnologyController extends AbstractController
{

    /**
     * @Route("/game/technology", name="game_technology")
     * @param SearchTechnologyRepository $searchTechnologyRepository
     * @return Response
     *
     * Cette function permet d'afficher la liste des technology de l'île
     */
    public function technology(SearchTechnologyRepository $searchTechnologyRepository): Response
    {
        $isle = $this->getUser()->getMainIsle();
        return $this->render('game/technology/technology.html.twig',
            [
                'technologies' => $searchTechnologyRepository->getAllTechnologiesByIsle($isle),
            ]
        );
    }

    /**
     * @Route("/game/technology/show/{id}", name="game_technology_show", methods={"GET"})
     * @param SearchTechnology $technology
     * @return RedirectResponse|Response
     *
     * Cette function permet d'afficher 1 technology voulu grace a l'id
     */
    public function showTechnology(SearchTechnology $technology)
    {
        if ($this->checkUserIsle($technology->getIsle())) {
            return $this->render('game/technology/show_technology.html.twig',
                [
                    'technology' => $technology
                ]
            );
        }
        return $this->redirectToRoute("game_technology");
    }

    /**
     * @Route("/game/technology/upgrade/timer-start/{id_technology}", name="game_technology_upgrade_start")
     * @param $id_technology
     * @param ObjectManager $manager
     * @return null|RedirectResponse
     *
     * Cette function permet de déclencher l'augmentation du niveau de la technologie
     */
    public function UpgradeTechnology($id_technology, ObjectManager $manager, Request $request): ?RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $technology = $manager->getRepository(SearchTechnology::class)->find($id_technology);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        // On vérifie que le joueur a assez de ressource pour construire la technology
        if ($isle->getWoodStock() >= $technology->getWoodCost() && $isle->getStoneStock() >= $technology->getStoneCost()
            && $isle->getMetalStock() >= $technology->getMetalCost()) {

            $resteOfWood = str_replace(' ', '',$session->get('wood')) - $technology->getWoodCost();
            $resteOfStone = str_replace(' ', '',$session->get('stone')) - $technology->getStoneCost();
            $resteOfMetal = str_replace(' ', '',$session->get('metal')) - $technology->getMetalCost();
            // On rend a l'utilisateur
            $isle->setWoodStock($resteOfWood);
            $isle->setStoneStock($resteOfStone);
            $isle->setMetalStock($resteOfMetal);

            $startDate = time();
            $technology->setStartDate($startDate);
            $searchTime = $technology->getSearchTime();
            $technology->setEndDate($startDate + $searchTime);

            $entityManager->persist($technology);
            $entityManager->persist($isle);
            $entityManager->flush();

            $session->set('wood', $isle->getWoodStock());
            $session->set('stone', $isle->getStoneStock());
            $session->set('metal', $isle->getMetalStock());

            return $this->redirectToRoute('game_technology');
        }
        $this->addFlash('error', 'Vous n\avez pas assez de ressources pour rechercher ce niveau de technologie.');
        return $this->redirectToRoute('game_technology');
    }

    /**
     * @Route("/game/technology/upgrade/timer-end/{id_technology}", name="game_technology_upgrade_end")
     * @param $id_technology
     * @param ObjectManager $manager
     * @return RedirectResponse
     *
     * Cette function met a jour les informations après la fin du 'timer de recherche'.
     */
    public function updateTechAfterTimer($id_technology, ObjectManager $manager): RedirectResponse
    {

        $entityManager = $this->getDoctrine()->getManager();
        $technology = $manager->getRepository(SearchTechnology::class)->find($id_technology);
        $isle_id = $this->getUser()->getMainIsle();
        $isle = $manager->getRepository(Isle::class)->find($isle_id);

        $totalCost = $technology->getWoodCost() + $technology->getStoneCost() + $technology->getMetalCost();

        // On améliore le batiment et change les caractéristiques
        $technology->setWoodCost($technology->getWoodCost() * 2.5);
        $technology->setStoneCost($technology->getStoneCost() * 2.5);
        $technology->setMetalCost($technology->getMetalCost() * 2.5);
        $technology->setSearchTime($technology->getSearchTime() * 1.5);
        $technology->setLevelTechnology($technology->getLevelTechnology() + 1);
        $technology->setEndDate(null);
        $technology->setStartDate(null);

        $powerPoint = $technology->upPowerPoint($totalCost);
        $actualPowerPoint = $isle->getPowerPoint();
        $isle->setPowerPoint($actualPowerPoint + $powerPoint);

        // On persist et on flush les données
        $entityManager->persist($isle);
        $entityManager->persist($technology);
        $entityManager->flush();

        return $this->redirectToRoute('game_technology');

    }

    /**
     * @Route("/game/technology/cancel/{id_technology}", name="game_technology_cancel")
     * @param $id_technology
     * @param ObjectManager $manager
     * @param Request $request
     * @return RedirectResponse
     *
     * Cette function permet d'annuler la technology en cours de recherche
     */
    public function cancelTech($id_technology, ObjectManager $manager, Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $id_isle = $this->getUser()->getMainIsle();
        $entityManager = $this->getDoctrine()->getManager();
        $technology = $manager->getRepository(SearchTechnology::class)->find($id_technology);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        $restOfWood = $technology->getWoodCost() / 2;
        $restOfStone = $technology->getStoneCost() / 2;
        $restOfMetal = $technology->getMetalCost() / 2;

        $isle->setWoodStock(str_replace(' ', '', $session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $technology->setEndDate(null);
        $technology->setStartDate(null);

        $entityManager->persist($isle);
        $entityManager->persist($technology);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_technology');
    }

    /**
     * @Route("/game/technology/destroy/{id_technology}", name="game_technology_destroy")
     * @param $id_technology
     * @param ObjectManager $manager
     * @param Request $request
     * @return RedirectResponse
     *
     * Cette function permet de détruire une niveau de technology.
     */
    public function destroyTech($id_technology, ObjectManager $manager, Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $id_isle = $this->getUser()->getMainIsle();
        $entityManager = $this->getDoctrine()->getManager();
        $technology = $manager->getRepository(SearchTechnology::class)->find($id_technology);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        $restOfWood = $technology->getWoodCost() / 10;
        $restOfStone = $technology->getStoneCost() / 10;
        $restOfMetal = $technology->getMetalCost() / 10;

        $isle->setWoodStock(str_replace(' ', '',$session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $technology->setWoodCost($technology->getWoodCost() / 2.5);
        $technology->setStoneCost($technology->getStoneCost() / 2.5);
        $technology->setMetalCost($technology->getMetalCost() / 2.5);
        $technology->setSearchTime($technology->getSearchTime() / 1.5);
        $technology->setLevelTechnology($technology->getLevelTechnology() - 1);
        $technology->setEndDate(null);
        $technology->setStartDate(null);

        $entityManager->persist($isle);
        $entityManager->persist($technology);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_technology');
    }

    public function checkUserIsle(Isle $isle): bool
    {
        return !($this->getUser() !== $isle->getUser());
    }
}