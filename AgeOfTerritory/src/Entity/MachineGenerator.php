<?php
namespace App\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\TrainingMachine;

class MachineGenerator
{
    public static function generatorMachine()
    {
        return [
            "Belier", "Trebuchet", "NavireTransport", "NavireGuerre", "Chasseur", "DroneEspion",
            "Bombardier", "Satellite", "AvionCargo"
        ];

    }

    public static function generatorBelier($isle, ObjectManager $manager, $machine){
        $belier = new TrainingMachine();
        $belier->setIsle($isle);
        $belier->setMachine($machine);
        $belier->setDamage(200);
        $belier->setHealth(30);
        $belier->setWoodCost(8000);
        $belier->setStoneCost(5000);
        $belier->setMetalCost(0);
        $belier->setFuelConsumption(50);
        $belier->setSpeed(10);
        $belier->setFreightCapacity(500);
        $belier->setTrainingTime(300);
        $belier->setNombre(0);
        $manager->persist($belier);
        $manager->flush();
    }

    public static function generatorTrebuchet($isle, ObjectManager $manager, $machine){
        $trebuchet = new TrainingMachine();
        $trebuchet->setIsle($isle);
        $trebuchet->setMachine($machine);
        $trebuchet->setDamage(350);
        $trebuchet->setHealth(80);
        $trebuchet->setWoodCost(10000);
        $trebuchet->setStoneCost(7000);
        $trebuchet->setMetalCost(1000);
        $trebuchet->setFuelConsumption(70);
        $trebuchet->setSpeed(10);
        $trebuchet->setFreightCapacity(90);
        $trebuchet->setTrainingTime(480);
        $trebuchet->setNombre(0);
        $manager->persist($trebuchet);
        $manager->flush();
    }

    public static function generatorNavireTransport($isle, ObjectManager $manager, $machine){
        $navireTransport = new TrainingMachine();
        $navireTransport->setIsle($isle);
        $navireTransport->setMachine($machine);
        $navireTransport->setDamage(30);
        $navireTransport->setHealth(150);
        $navireTransport->setWoodCost(10000);
        $navireTransport->setStoneCost(5000);
        $navireTransport->setMetalCost(5000);
        $navireTransport->setFuelConsumption(300);
        $navireTransport->setSpeed(14);
        $navireTransport->setFreightCapacity(15000);
        $navireTransport->setTrainingTime(300);
        $navireTransport->setNombre(0);
        $manager->persist($navireTransport);
        $manager->flush();
    }

    public static function generatorNavireGuerre($isle, ObjectManager $manager, $machine){
        $navireGuerre = new TrainingMachine();
        $navireGuerre->setIsle($isle);
        $navireGuerre->setMachine($machine);
        $navireGuerre->setDamage(1650);
        $navireGuerre->setHealth(2000);
        $navireGuerre->setWoodCost(25000);
        $navireGuerre->setStoneCost(20000);
        $navireGuerre->setMetalCost(18000);
        $navireGuerre->setFuelConsumption(800);
        $navireGuerre->setSpeed(14);
        $navireGuerre->setFreightCapacity(1500);
        $navireGuerre->setTrainingTime(800);
        $navireGuerre->setNombre(0);
        $manager->persist($navireGuerre);
        $manager->flush();
    }

    public static function generatorChasseur($isle, ObjectManager $manager, $machine){
        $chasseur = new TrainingMachine();
        $chasseur->setIsle($isle);
        $chasseur->setMachine($machine);
        $chasseur->setDamage(2000);
        $chasseur->setHealth(2000);
        $chasseur->setWoodCost(26000);
        $chasseur->setStoneCost(22000);
        $chasseur->setMetalCost(20000);
        $chasseur->setFuelConsumption(1000);
        $chasseur->setSpeed(16);
        $chasseur->setFreightCapacity(1500);
        $chasseur->setTrainingTime(900);
        $chasseur->setNombre(0);
        $manager->persist($chasseur);
        $manager->flush();
    }

    public static function generatorDroneEspion($isle, ObjectManager $manager, $machine){
        $droneEspion = new TrainingMachine();
        $droneEspion->setIsle($isle);
        $droneEspion->setMachine($machine);
        $droneEspion->setDamage(50);
        $droneEspion->setHealth(50);
        $droneEspion->setWoodCost(6000);
        $droneEspion->setStoneCost(6000);
        $droneEspion->setMetalCost(6000);
        $droneEspion->setFuelConsumption(150);
        $droneEspion->setSpeed(16);
        $droneEspion->setFreightCapacity(250);
        $droneEspion->setTrainingTime(240);
        $droneEspion->setNombre(0);
        $manager->persist($droneEspion);
        $manager->flush();
    }

    public static function generatorBombardier($isle, ObjectManager $manager, $machine){
        $bombardier = new TrainingMachine();
        $bombardier->setIsle($isle);
        $bombardier->setMachine($machine);
        $bombardier->setDamage(2600);
        $bombardier->setHealth(3000);
        $bombardier->setWoodCost(32000);
        $bombardier->setStoneCost(32000);
        $bombardier->setMetalCost(27000);
        $bombardier->setFuelConsumption(1400);
        $bombardier->setSpeed(16);
        $bombardier->setFreightCapacity(4000);
        $bombardier->setTrainingTime(1300);
        $bombardier->setNombre(0);
        $manager->persist($bombardier);
        $manager->flush();
    }

    public static function generatorSatellite($isle, ObjectManager $manager, $machine){
        $satellite = new TrainingMachine();
        $satellite->setIsle($isle);
        $satellite->setMachine($machine);
        $satellite->setDamage(6000);
        $satellite->setHealth(8000);
        $satellite->setWoodCost(55000);
        $satellite->setStoneCost(70000);
        $satellite->setMetalCost(60000);
        $satellite->setFuelConsumption(4000);
        $satellite->setSpeed(18);
        $satellite->setFreightCapacity(6000);
        $satellite->setTrainingTime(2800);
        $satellite->setNombre(0);
        $manager->persist($satellite);
        $manager->flush();
    }

    public static function generatorAvionCargo($isle, ObjectManager $manager, $machine){
        $avionCargo = new TrainingMachine();
        $avionCargo->setIsle($isle);
        $avionCargo->setMachine($machine);
        $avionCargo->setDamage(500);
        $avionCargo->setHealth(4000);
        $avionCargo->setWoodCost(20000);
        $avionCargo->setStoneCost(20000);
        $avionCargo->setMetalCost(15000);
        $avionCargo->setFuelConsumption(1000);
        $avionCargo->setSpeed(16);
        $avionCargo->setFreightCapacity(75000);
        $avionCargo->setTrainingTime(800);
        $avionCargo->setNombre(0);
        $manager->persist($avionCargo);
        $manager->flush();
    }
}
