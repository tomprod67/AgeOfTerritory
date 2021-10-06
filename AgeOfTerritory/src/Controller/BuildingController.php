<?php

namespace App\Controller;

use App\Entity\Isle;
use App\Repository\IsleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BuildBuildingRepository;
use App\Entity\Building;
use App\Entity\BuildBuilding;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class BuildingController extends AbstractController
{

    /**
     * @Route("/game/building", name="game_building")
     * @param BuildBuildingRepository $buildBuildingRepository
     * @return Response
     *
     * Cette function permet d'afficher la liste des bâtiments de l'île
     */
    public function building(BuildBuildingRepository $buildBuildingRepository): Response
    {
        $isle = $this->getUser()->getMainIsle();
        return $this->render('game/building/building.html.twig',
            [
                'buildings' => $buildBuildingRepository->getAllBuildingsByIsle($isle)
            ]
        );
    }


    /**
     * @Route("/game/building/show/{id}", name="game_building_show", methods={"GET"})
     * @param BuildBuilding $building
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * Cette function permet d'afficher 1 bâtiment voulu grace a l'id
     */
    public function showBuilding(BuildBuilding $building)
    {
        if($this->checkUserIsle($building->getIsle())){
            return $this->render('game/building/show.html.twig',
                [
                    'building' => $building
                ]
            );
        }
        return $this->redirectToRoute('game_building');
    }


    /**
     * @Route("/game/building/upgrade/timer-start/{id_building}", name="game_building_upgrade_start")
     * @param $id_building
     * @param ObjectManager $manager
     * @return null|RedirectResponse
     *
     * Cette function permet de déclencher l'augmentation du niveau du bâtiment
     */
    public function upgradeBuild($id_building, ObjectManager $manager, Request $request): ?RedirectResponse
    {
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $building = $manager->getRepository(BuildBuilding::class)->find($id_building);
        // On vérifie que le joueur a assez de ressource pour construire le batiment
        if ($isle->getWoodStock() >= $building->getWoodCost() && $isle->getStoneStock() >= $building->getStoneCost()
            && $isle->getMetalStock() >= $building->getMetalCost())
        {
            // On calcul combien on doit rendre a l'utilisateur
            $resteOfWood = str_replace(' ', '',$session->get('wood')) - $building->getWoodCost();
            $resteOfStone = str_replace(' ', '',$session->get('stone')) - $building->getStoneCost();
            $resteOfMetal = str_replace(' ', '',$session->get('metal')) - $building->getMetalCost();
            // On rend a l'utilisateur
            $isle->setWoodStock($resteOfWood);
            $isle->setStoneStock($resteOfStone);
            $isle->setMetalStock($resteOfMetal);

            $startDate = time();
            $building->setStartDate($startDate);
            $buildTime = $building->getBuildTime();
            $building->setEndDate($startDate + $buildTime);

            $entityManager->persist($building);
            $entityManager->persist($isle);
            $entityManager->flush();

            $session->set('wood', $isle->getWoodStock());
            $session->set('stone', $isle->getStoneStock());
            $session->set('metal', $isle->getMetalStock());
            return $this->redirectToRoute('game_building');
        }
        $this->addFlash('error', 'Vous n\avez pas assez de ressources pour construire ce bâtiment');
        return $this->redirectToRoute('game_building');
    }

    /**
     * @Route("/game/building/upgrade/timer-end/{id_building}", name="game_building_upgrade_end")
     * @param GameController $game
     * @param $id_building
     * @param ObjectManager $manager
     * @return RedirectResponse
     *
     * Cette function met a jour les informations après la fin du 'timer de construction'.
     */
    public function updateBuildAfterTimer(GameController $game, $id_building, ObjectManager $manager): RedirectResponse
    {

        $entityManager = $this->getDoctrine()->getManager();
        $id_isle = $this->getUser()->getMainIsle();
        $isle = $manager->getRepository(Isle::class)->find($id_isle);
        $building = $manager->getRepository(BuildBuilding::class)->find($id_building);
        $totalCost = $building->getWoodCost() + $building->getStoneCost() + $building->getMetalCost();
        // On améliore le batiment et change les caractéristiques
        $building->setWoodCost($building->getWoodCost() * 2.5);
        $building->setStoneCost($building->getStoneCost() * 2.5);
        $building->setMetalCost($building->getMetalCost() * 2.5);
        $building->setBuildTime($building->getBuildTime() * 1.5);
        $building->setBuildingProd($building->getBuildingProd() * 1.5);
        $building->setLevelBuilding($building->getLevelBuilding() + 1);
        $building->setEndDate(null);
        $building->setStartDate(null);

        $entityManager->persist($building);
        $entityManager->flush();

        $id = $building->getBuilding()->getId();
        switch ($id){
            case 1:
                $isle->setWoodProd($building->getBuildingProd());
                break;
            case 2:
                $isle->setStoneProd($building->getBuildingProd());
                break;
            case 3:
                $isle->setMetalProd($building->getBuildingProd());
                break;
            case 4:
                $isle->setOilProd($building->getBuildingProd());
                break;
        }

        $powerPoint = $game->upPowerPoint($totalCost);
        $actualPowerPoint = $isle->getPowerPoint();
        $isle->setPowerPoint($actualPowerPoint + $powerPoint);
        // On persist et on flush les données
        $entityManager->persist($isle);
        $entityManager->persist($building);
        $entityManager->flush();

        return $this->redirectToRoute('game_building');
    }

    /**
     * @Route("/game/building/cancel/{id_building}", name="game_building_cancel")
     * @param $id_building
     * @param ObjectManager $manager
     * @param Request $request
     * @return RedirectResponse
     *
     * Cette function permet d'annuler le bâtiment en cours de construction
     */
    public function cancelBuild($id_building, ObjectManager $manager, Request $request): RedirectResponse
    {
        $id_isle = $this->getUser()->getMainIsle();
        $session = $request->getSession();
        $entityManager = $this->getDoctrine()->getManager();
        $building = $manager->getRepository(BuildBuilding::class)->find($id_building);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        $restOfWood = $building->getWoodCost() / 2;
        $restOfStone = $building->getStoneCost() / 2;
        $restOfMetal = $building->getMetalCost() / 2;

        $isle->setWoodStock(str_replace(' ', '', $session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $building->setEndDate(null);
        $building->setStartDate(null);
        $entityManager->persist($isle);
        $entityManager->persist($building);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_building');

    }

    /**
     * @Route("/game/building/destroy/{id_building}", name="game_building_destroy")
     * @param $id_building
     * @param ObjectManager $manager
     * @return RedirectResponse
     *
     * Cette function permet de détruire une niveau du batiment.
     */
    public function destroyBuild($id_building, ObjectManager $manager, Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $id_isle = $this->getUser()->getMainIsle();
        $entityManager = $this->getDoctrine()->getManager();
        $building = $manager->getRepository(BuildBuilding::class)->find($id_building);
        $isle = $manager->getRepository(Isle::class)->find($id_isle);

        $restOfWood = $building->getWoodCost() / 10;
        $restOfStone = $building->getStoneCost() / 10;
        $restOfMetal = $building->getMetalCost() / 10;

        $isle->setWoodStock(str_replace(' ', '',$session->get('wood')) + $restOfWood);
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')) + $restOfStone);
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')) + $restOfMetal);

        $building->setWoodCost($building->getWoodCost() / 2.5);
        $building->setStoneCost($building->getStoneCost() / 2.5);
        $building->setMetalCost($building->getMetalCost() / 2.5);
        $building->setBuildTime($building->getBuildTime() / 1.5);
        $building->setBuildingProd($building->getBuildingProd() / 1.5);
        $building->setLevelBuilding($building->getLevelBuilding() - 1);
        $building->setEndDate(null);
        $building->setStartDate(null);

        $entityManager->persist($isle);
        $entityManager->persist($building);
        $entityManager->flush();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());

        return $this->redirectToRoute('game_building');
    }

    public function checkUserIsle(Isle $isle): bool
    {
        return !($this->getUser() !== $isle->getUser());
    }
}