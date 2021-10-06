<?php
namespace App\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\TrainingUnit;

class UnitGenerator
{
    public static function generatorUnit()
    {
        return [
            "CombattantPrimitif", "Guerrier", "Archer", "Chevalier", "Soldat", "SoldatArmureLourde",
            "Mastodonte", "MastodonteLourd", "Archeologue"
        ];

    }

    public static function generatorCombattantPrimitif($isle, ObjectManager $manager, $unit){
        $combattantPrimitif = new TrainingUnit();
        $combattantPrimitif->setIsle($isle);
        $combattantPrimitif->setUnit($unit);
        $combattantPrimitif->setDamage(50);
        $combattantPrimitif->setHealth(10);
        $combattantPrimitif->setWoodCost(3000);
        $combattantPrimitif->setStoneCost(1000);
        $combattantPrimitif->setMetalCost(0);
        $combattantPrimitif->setFuelConsumption(20);
        $combattantPrimitif->setSpeed(12);
        $combattantPrimitif->setFreightCapacity(50);
        $combattantPrimitif->setTrainingTime(55);
        $combattantPrimitif->setNombre(0);
        $manager->persist($combattantPrimitif);
        $manager->flush();
    }

    public static function generatorGuerrier($isle, ObjectManager $manager, $unit){
        $guerrier = new TrainingUnit();
        $guerrier->setIsle($isle);
        $guerrier->setUnit($unit);
        $guerrier->setDamage(150);
        $guerrier->setHealth(30);
        $guerrier->setWoodCost(6000);
        $guerrier->setStoneCost(4000);
        $guerrier->setMetalCost(0);
        $guerrier->setFuelConsumption(50);
        $guerrier->setSpeed(12);
        $guerrier->setFreightCapacity(75);
        $guerrier->setTrainingTime(180);
        $guerrier->setNombre(0);
        $manager->persist($guerrier);
        $manager->flush();
    }

    public static function generatorArcher($isle, ObjectManager $manager, $unit){
        $archer = new TrainingUnit();
        $archer->setIsle($isle);
        $archer->setUnit($unit);
        $archer->setDamage(170);
        $archer->setHealth(50);
        $archer->setWoodCost(7000);
        $archer->setStoneCost(5000);
        $archer->setMetalCost(500);
        $archer->setFuelConsumption(50);
        $archer->setSpeed(12);
        $archer->setFreightCapacity(75);
        $archer->setTrainingTime(200);
        $archer->setNombre(0);
        $manager->persist($archer);
        $manager->flush();
    }

    public static function generatorChevalier($isle, ObjectManager $manager, $unit){
        $chevalier = new TrainingUnit();
        $chevalier->setIsle($isle);
        $chevalier->setUnit($unit);
        $chevalier->setDamage(250);
        $chevalier->setHealth(80);
        $chevalier->setWoodCost(9000);
        $chevalier->setStoneCost(6000);
        $chevalier->setMetalCost(1500);
        $chevalier->setFuelConsumption(60);
        $chevalier->setSpeed(15);
        $chevalier->setFreightCapacity(100);
        $chevalier->setTrainingTime(220);
        $chevalier->setNombre(0);
        $manager->persist($chevalier);
        $manager->flush();
    }

    public static function generatorSoldat($isle, ObjectManager $manager, $unit){
        $soldat = new TrainingUnit();
        $soldat->setIsle($isle);
        $soldat->setUnit($unit);
        $soldat->setDamage(600);
        $soldat->setHealth(200);
        $soldat->setWoodCost(12000);
        $soldat->setStoneCost(9000);
        $soldat->setMetalCost(3500);
        $soldat->setFuelConsumption(100);
        $soldat->setSpeed(12);
        $soldat->setFreightCapacity(150);
        $soldat->setTrainingTime(300);
        $soldat->setNombre(0);
        $manager->persist($soldat);
        $manager->flush();
    }

    public static function generatorSoldatArmureLourde($isle, ObjectManager $manager, $unit){
        $soldatArmureLourde = new TrainingUnit();
        $soldatArmureLourde->setIsle($isle);
        $soldatArmureLourde->setUnit($unit);
        $soldatArmureLourde->setDamage(800);
        $soldatArmureLourde->setHealth(600);
        $soldatArmureLourde->setWoodCost(15000);
        $soldatArmureLourde->setStoneCost(11000);
        $soldatArmureLourde->setMetalCost(7000);
        $soldatArmureLourde->setFuelConsumption(150);
        $soldatArmureLourde->setSpeed(10);
        $soldatArmureLourde->setFreightCapacity(250);
        $soldatArmureLourde->setTrainingTime(500);
        $soldatArmureLourde->setNombre(0);
        $manager->persist($soldatArmureLourde);
        $manager->flush();
    }

    public static function generatorMastodonte($isle, ObjectManager $manager, $unit){
        $mastodonte = new TrainingUnit();
        $mastodonte->setIsle($isle);
        $mastodonte->setUnit($unit);
        $mastodonte->setDamage(1200);
        $mastodonte->setHealth(1000);
        $mastodonte->setWoodCost(18000);
        $mastodonte->setStoneCost(18000);
        $mastodonte->setMetalCost(12000);
        $mastodonte->setFuelConsumption(300);
        $mastodonte->setSpeed(14);
        $mastodonte->setFreightCapacity(350);
        $mastodonte->setTrainingTime(700);
        $mastodonte->setNombre(0);
        $manager->persist($mastodonte);
        $manager->flush();
    }

    public static function generatorMastodonteLourd($isle, ObjectManager $manager, $unit){
        $mastodonteLourd = new TrainingUnit();
        $mastodonteLourd->setIsle($isle);
        $mastodonteLourd->setUnit($unit);
        $mastodonteLourd->setDamage(1500);
        $mastodonteLourd->setHealth(1500);
        $mastodonteLourd->setWoodCost(22000);
        $mastodonteLourd->setStoneCost(21000);
        $mastodonteLourd->setMetalCost(17000);
        $mastodonteLourd->setFuelConsumption(400);
        $mastodonteLourd->setSpeed(14);
        $mastodonteLourd->setFreightCapacity(400);
        $mastodonteLourd->setTrainingTime(800);
        $mastodonteLourd->setNombre(0);
        $manager->persist($mastodonteLourd);
        $manager->flush();
    }

    public static function generatorArcheologue($isle, ObjectManager $manager, $unit){
        $archeologue = new TrainingUnit();
        $archeologue->setIsle($isle);
        $archeologue->setUnit($unit);
        $archeologue->setDamage(20);
        $archeologue->setHealth(20);
        $archeologue->setWoodCost(8000);
        $archeologue->setStoneCost(8000);
        $archeologue->setMetalCost(8000);
        $archeologue->setFuelConsumption(100);
        $archeologue->setSpeed(14);
        $archeologue->setFreightCapacity(1000);
        $archeologue->setTrainingTime(600);
        $archeologue->setNombre(0);
        $manager->persist($archeologue);
        $manager->flush();
    }
}

