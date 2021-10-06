<?php
namespace App\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class BuildingGenerator{

    public static function generatorBuilding(){
        return
            [
                'scierie', 'carrierePierre', 'MineMetal', 'SynthetiseurCarburant', 'CentreEntrainement',
                'UsineArsenal', 'CentreRecherche', 'CentreDefense',
            ];
    }

    public static function generatorScierie($isle, ObjectManager $manager, $building){

        $scierie = new BuildBuilding();
        $scierie->setIsle($isle);
        $scierie->setBuilding($building);
        $scierie->setLevelBuilding(0);
        $scierie->setWoodCost(30);
        $scierie->setStoneCost(15);
        $scierie->setMetalCost(0);
        $scierie->setBuildTime(55);
        $scierie->setBuildingProd(98);
        $manager->persist($scierie);
        $manager->flush();
    }

    public static function generatorCarrierePierre($isle, ObjectManager $manager, $building){

        $carrierePierre = new BuildBuilding();
        $carrierePierre->setIsle($isle);
        $carrierePierre->setBuilding($building);
        $carrierePierre->setLevelBuilding(0);
        $carrierePierre->setWoodCost(48);
        $carrierePierre->setStoneCost(24);
        $carrierePierre->setMetalCost(0);
        $carrierePierre->setBuildTime(65);
        $carrierePierre->setBuildingProd(54);
        $manager->persist($carrierePierre);
        $manager->flush();
    }

    public static function generatorMineMetal($isle, ObjectManager $manager, $building){

        $mineMetal = new BuildBuilding();
        $mineMetal->setIsle($isle);
        $mineMetal->setBuilding($building);
        $mineMetal->setLevelBuilding(0);
        $mineMetal->setWoodCost(210);
        $mineMetal->setStoneCost(160);
        $mineMetal->setMetalCost(0);
        $mineMetal->setBuildTime(75);
        $mineMetal->setBuildingProd(22);
        $manager->persist($mineMetal);
        $manager->flush();
    }

    public static function generatorSynthetiseurCarburant($isle, ObjectManager $manager, $building){

        $synthetiseurCarburant = new BuildBuilding();
        $synthetiseurCarburant->setIsle($isle);
        $synthetiseurCarburant->setBuilding($building);
        $synthetiseurCarburant->setLevelBuilding(0);
        $synthetiseurCarburant->setWoodCost(210);
        $synthetiseurCarburant->setStoneCost(120);
        $synthetiseurCarburant->setMetalCost(40);
        $synthetiseurCarburant->setBuildTime(75);
        $synthetiseurCarburant->setBuildingProd(66);
        $manager->persist($synthetiseurCarburant);
        $manager->flush();
    }

    public static function generatorCentreEntrainement($isle, ObjectManager $manager, $building){

        $centreEntrainement = new BuildBuilding();
        $centreEntrainement->setIsle($isle);
        $centreEntrainement->setBuilding($building);
        $centreEntrainement->setLevelBuilding(0);
        $centreEntrainement->setWoodCost(400);
        $centreEntrainement->setStoneCost(200);
        $centreEntrainement->setMetalCost(100);
        $centreEntrainement->setBuildTime(85);
        $centreEntrainement->setBuildingProd(0);
        $manager->persist($centreEntrainement);
        $manager->flush();
    }

    public static function generatorUsineArsenal($isle, ObjectManager $manager, $building){
        $usineArsenal = new BuildBuilding();
        $usineArsenal->setIsle($isle);
        $usineArsenal->setBuilding($building);
        $usineArsenal->setLevelBuilding(0);
        $usineArsenal->setWoodCost(400);
        $usineArsenal->setStoneCost(200);
        $usineArsenal->setMetalCost(100);
        $usineArsenal->setBuildTime(85);
        $usineArsenal->setBuildingProd(0);
        $manager->persist($usineArsenal);
        $manager->flush();
    }

    public static function generatorCentreRecherche($isle, ObjectManager $manager, $building){
        $centreRecherche = new BuildBuilding();
        $centreRecherche->setIsle($isle);
        $centreRecherche->setBuilding($building);
        $centreRecherche->setLevelBuilding(0);
        $centreRecherche->setWoodCost(400);
        $centreRecherche->setStoneCost(200);
        $centreRecherche->setMetalCost(100);
        $centreRecherche->setBuildTime(85);
        $centreRecherche->setBuildingProd(0);
        $manager->persist($centreRecherche);
        $manager->flush();
    }

    public static function generatorCentreDefense($isle, ObjectManager $manager, $building){
        $centreDefense = new BuildBuilding();
        $centreDefense->setIsle($isle);
        $centreDefense->setBuilding($building);
        $centreDefense->setLevelBuilding(0);
        $centreDefense->setWoodCost(400);
        $centreDefense->setStoneCost(200);
        $centreDefense->setMetalCost(100);
        $centreDefense->setBuildTime(85);
        $centreDefense->setBuildingProd(0);
        $manager->persist($centreDefense);
        $manager->flush();
    }
}