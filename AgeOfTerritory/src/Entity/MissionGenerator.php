<?php
namespace App\Entity;

use App\Controller\GameController;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Mission;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;

class MissionGenerator
{

    public static function generatorSpyMission($strikerIsle, $targetIsle, $strikerTroops, $targetTroopsAndDefenses, ObjectManager $manager)
    {
        $spyMission = new Mission();
        $spyMission->setStrikerIsle($strikerIsle);
        $spyMission->setTargetIsle($targetIsle);
        $spyMission->setMission("spy");
        $spyMission->setStartDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        //$spyMission->setEndDate(new \DateTime('now')+$durée);
        //$spyMission->setResult(30);
        //$spyMission->setEtat(30);
        $spyMission->setStrikerTroops($strikerTroops);
        $spyMission->setTargetTroopsAndDefenses($targetTroopsAndDefenses);
        $manager->persist($spyMission);
        $manager->flush();
    }

    public static function generatorAttackMission($strikerIsle, $targetIsle, $strikerTroops, $targetTroopsAndDefenses, $hitFreight, $timeInSec, ObjectManager $manager)
    {
        $now = new \DateTime('now');
        $now = $now->format('U');
        $endDate = (int)$now + $timeInSec;
        $attackMission = new Mission();
        $attackMission->setStrikerIsle($strikerIsle);
        $attackMission->setTargetIsle($targetIsle);
        $attackMission->setMission("Attack");
        $attackMission->setStartDate((int)$now);
        $attackMission->setEndDate($endDate);
        $attackMission->setEtat("In progress");
        $attackMission->setStrikerTroops($strikerTroops);
        $attackMission->setTargetTroopsAndDefenses($targetTroopsAndDefenses);
        $attackMission->setHitFreight($hitFreight);
        $manager->persist($attackMission);
        $manager->flush();
    }
}