<?php
namespace App\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\BuildDefense;

class DefenseGenerator
{
    public static function generatorDefense()
    {
        return [
            "Lanceur", "LanceFleche", "Canon", "TourGarde", "Tourelle", "CanonIons", "CanonPlasma"
        ];

    }

    public static function generatorLanceur($isle, ObjectManager $manager, $defense){
        $lanceur = new BuildDefense();
        $lanceur->setIsle($isle);
        $lanceur->setDefense($defense);
        $lanceur->setDamage(30);
        $lanceur->setHealth(30);
        $lanceur->setWoodCost(2000);
        $lanceur->setStoneCost(1000);
        $lanceur->setMetalCost(0);
        $lanceur->setBuildTime(55);
        $lanceur->setNombre(0);
        $manager->persist($lanceur);
        $manager->flush();
    }

    public static function generatorLanceFleche($isle, ObjectManager $manager, $defense){
        $lanceFleche = new BuildDefense();
        $lanceFleche->setIsle($isle);
        $lanceFleche->setDefense($defense);
        $lanceFleche->setDamage(200);
        $lanceFleche->setHealth(70);
        $lanceFleche->setWoodCost(5000);
        $lanceFleche->setStoneCost(3000);
        $lanceFleche->setMetalCost(1000);
        $lanceFleche->setBuildTime(300);
        $lanceFleche->setNombre(0);
        $manager->persist($lanceFleche);
        $manager->flush();
    }

    public static function generatorCanon($isle, ObjectManager $manager, $defense){
        $canon = new BuildDefense();
        $canon->setIsle($isle);
        $canon->setDefense($defense);
        $canon->setDamage(230);
        $canon->setHealth(150);
        $canon->setWoodCost(6500);
        $canon->setStoneCost(3000);
        $canon->setMetalCost(3000);
        $canon->setBuildTime(360);
        $canon->setNombre(0);
        $manager->persist($canon);
        $manager->flush();
    }

    public static function generatorTourGarde($isle, ObjectManager $manager, $defense){
        $tourGarde = new BuildDefense();
        $tourGarde->setIsle($isle);
        $tourGarde->setDefense($defense);
        $tourGarde->setDamage(650);
        $tourGarde->setHealth(600);
        $tourGarde->setWoodCost(10000);
        $tourGarde->setStoneCost(5000);
        $tourGarde->setMetalCost(5000);
        $tourGarde->setBuildTime(600);
        $tourGarde->setNombre(0);
        $manager->persist($tourGarde);
        $manager->flush();
    }

    public static function generatorTourelle($isle, ObjectManager $manager, $defense){
        $tourelle = new BuildDefense();
        $tourelle->setIsle($isle);
        $tourelle->setDefense($defense);
        $tourelle->setDamage(1400);
        $tourelle->setHealth(1000);
        $tourelle->setWoodCost(15000);
        $tourelle->setStoneCost(12000);
        $tourelle->setMetalCost(7000);
        $tourelle->setBuildTime(800);
        $tourelle->setNombre(0);
        $manager->persist($tourelle);
        $manager->flush();
    }

    public static function generatorCanonIons($isle, ObjectManager $manager, $defense){
        $canonIons = new BuildDefense();
        $canonIons->setIsle($isle);
        $canonIons->setDefense($defense);
        $canonIons->setDamage(2500);
        $canonIons->setHealth(2000);
        $canonIons->setWoodCost(25000);
        $canonIons->setStoneCost(30000);
        $canonIons->setMetalCost(15000);
        $canonIons->setBuildTime(900);
        $canonIons->setNombre(0);
        $manager->persist($canonIons);
        $manager->flush();
    }

    public static function generatorCanonPlasma($isle, ObjectManager $manager, $defense){
        $canonPlasma = new BuildDefense();
        $canonPlasma->setIsle($isle);
        $canonPlasma->setDefense($defense);
        $canonPlasma->setDamage(4500);
        $canonPlasma->setHealth(7000);
        $canonPlasma->setWoodCost(45000);
        $canonPlasma->setStoneCost(40000);
        $canonPlasma->setMetalCost(60000);
        $canonPlasma->setBuildTime(1600);
        $canonPlasma->setNombre(0);
        $manager->persist($canonPlasma);
        $manager->flush();
    }

}