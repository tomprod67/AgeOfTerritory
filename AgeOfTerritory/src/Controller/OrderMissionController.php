<?php

namespace App\Controller;

use App\Entity\MissionGenerator;
use App\Repository\BuildDefenseRepository;
use App\Repository\MissionRepository;
use App\Repository\TrainingMachineRepository;
use App\Repository\TrainingUnitRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Isle;
use App\Repository\IsleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;



/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class OrderMissionController extends AbstractController
{


    public function getWarStats($unitsStriker, $machinesStriker, $targetUnits, $targetMachines, $targetDefenses, $speedInSec): array
    {
        $powerStriker = 0;
        $powerTarget = 0;
        $totalDamageStriker = 0;
        $totalHealthStriker = 0;
        $totalDamageTarget = 0;
        $totalHealthTarget = 0;
        $strikerTroops = [];
        $targetTroopsAndDefense = [];

        if ($unitsStriker !== null) {
            foreach ($unitsStriker as $unit) {
                if ((int)$unit['nbUnit'] > 0) {
                    $unitName = $unit['unit']->getUnit()->getName();
                    $unitDamage = $unit['unit']->getDamage();
                    $unitHealth = (int)$unit['unit']->getHealth();
                    $nbUnit = (int)$unit['nbUnit'];
                    $powerStriker += ($unitDamage + $unitHealth) * $nbUnit;
                    $totalDamageStriker += $unitDamage;
                    $totalHealthStriker += $unitHealth;
                    $strikerTroops[] = [$unitName => $unit['unit'],
                        'nbSubmited' => $nbUnit];
                } else {
                    break;
                }
            }
        }
        if ($machinesStriker !== null) {
            foreach ($machinesStriker as $machine) {
                if ((int)$machine['nbMachine'] > 0) {
                    $machineName = $machine['machine']->getMachine()->getName();
                    $machineDamage = (int)$machine['machine']->getDamage();
                    $machineHealth = (int)$machine['machine']->getHealth();
                    $nbMachine = (int)$machine['nbMachine'];
                    $powerStriker += ($machineDamage + $machineHealth) * $nbMachine;
                    $totalDamageStriker += $machineDamage;
                    $totalHealthStriker += $machineHealth;
                    $strikerTroops[] = [
                        $machineName => $machine['machine'],
                        'nbSubmited' => $nbMachine
                    ];
                } else {
                    break;
                }
            }
        }
        if ($targetUnits !== null) {
            foreach ($targetUnits as $unit) {
                if ((int)$unit->getNombre() > 0) {
                    $unitName = $unit->getUnit()->getName();
                    $unitDamage = (int)$unit->getDamage();
                    $unitHealth = (int)$unit->getHealth();
                    $nbUnit = (int)$unit->getNombre();
                    $powerTarget += ($unitDamage + $unitHealth) * $nbUnit;
                    $totalDamageTarget += $unitDamage;
                    $totalHealthTarget += $unitHealth;
                    $targetTroopsAndDefense[] = [$unitName => $unit,
                        'nbSubmited' => $nbUnit];
                } else {
                    break;
                }
            }
        }
        if ($targetMachines !== null) {
            foreach ($targetMachines as $machine) {
                if ((int)$machine->getNombre() > 0) {
                    $machineName = $machine->getMachine()->getName();
                    $machineDamage = (int)$machine->getDamage();
                    $machineHealth = (int)$machine->getHealth();
                    $nbMachine = (int)$machine->getNombre();
                    $powerTarget += ($machineDamage + $machineHealth) * $nbMachine;
                    $totalDamageTarget += $machineDamage;
                    $totalHealthTarget += $machineHealth;
                    $targetTroopsAndDefense[] = [
                        $machineName => $machine,
                        'nbSubmited' => $nbMachine
                    ];
                } else {
                    break;
                }
            }
        }
        if ($targetDefenses !== null) {
            foreach ($targetDefenses as $defense) {

                if ((int)$defense->getNombre() > 0) {
                    $defenseName = $defense->getDefense()->getName();
                    $defenseDamage = (int)$defense->getDamage();
                    $defenseHealth = (int)$defense->getHealth();
                    $nbDefense = (int)$defense->getNombre();
                    $powerTarget += ($defenseDamage + $defenseHealth) * $nbDefense;
                    $totalDamageTarget += $defenseDamage;
                    $totalHealthTarget += $defenseHealth;
                    $targetTroopsAndDefense[] = [
                        $defenseName => $defense,
                        'nbSubmited' => $nbDefense
                    ];
                } else {
                    break;
                }
            }
        }
        return [
            'warStats' => [
                'strikerTroops' => $strikerTroops,
                'targetTroopsAndDefenses' => $targetTroopsAndDefense,
                'totalPowerStriker' => $powerStriker,
                'totalHealthStriker' => $totalHealthStriker,
                'totalDamageStriker' => $totalDamageStriker,
                'totalPowerTarget' => $powerTarget,
                'totalHealthTarget' => $totalHealthTarget,
                'totalDamageTarget' => $totalDamageTarget,
                'speedMissionInSec' => $speedInSec
            ]
        ];
    }

    /**
     * Route("/game/coordinate/{targetLongitude}/{targetLatitude}/{targetPosition}", name="game_spyOnMap")
     */
    /*public function spyOnMap(Session $session, $targetLongitude, $targetLatitude, $targetPosition, IsleRepository $isleRepository, ObjectManager $manager,
                             TrainingUnitRepository $trainingUnitRepository, TrainingMachineRepository $trainingMachineRepository,
                             SearchTechnologyRepository $searchTechnologyRepository, TechnologyRepository $technologyRepository, UnitRepository $unitRepository, MachineRepository $machineRepository, BuildDefenseRepository $buildDefenseRepository)
    {
        $striker = $this->getUser();
        $targetIsle = $isleRepository->getIsleByCoordinate($targetLongitude, $targetLatitude, $targetPosition);
        if ($targetIsle->getName() != "Emplacement Libre") {
            $target = $targetIsle->getUser();
            $targetUnits = $trainingUnitRepository->getUnitsByNombreAndIsle($targetIsle);
            $targetMachines = $trainingMachineRepository->getMachinesByNombreAndIsle($targetIsle);
            $targetDefenses = $buildDefenseRepository->getDefensesByNombreAndIsle($targetIsle);

            $tabTargetTroopsAndDefensesFormat = $this->formatTargetTroopsAndDefensesForDatabase($targetUnits, $targetMachines, $targetDefenses);

            if ($target != $striker) {
                $strikerIsle = $striker->getMainIsle();
                $longitude = $targetIsle->getLongitude();
                $latitude = $targetIsle->getLatitude();

                if ($striker->getPreferenceMachineSpy() === null && $striker->getPreferenceUnitSpy() === null) {
                    $this->addFlash("errors_preferenceSpy", "Vous devez d'abord renseigner vos préférences pour utiliser ce raccourci.");
                    return $this->redirectToRoute('game_account');
                } else {

                    $preferenceSpy = $this->checkPreferenceSpyUser($striker, $trainingMachineRepository, $trainingUnitRepository);

                    MissionGenerator::generatorSpyMission($strikerIsle, $targetIsle, $preferenceSpy, $tabTargetTroopsAndDefensesFormat, $manager);
                    MessageGenerator::generatorAlertEspionnage($striker, $target, $manager);
                    MessageGenerator::generatorRapportEspionnage($striker, $striker, $manager, $target);

                    $session->set('targetLongitude', $longitude);
                    $session->set('targetLatitude', $latitude);

                    return $this->redirectToRoute('game_map');
                }
            } else {
                $this->addFlash("errors_checkSpy", "Vous ne pouvez pas espionner cette elle vous appartient !");
                return $this->redirectToRoute('game_map');
            }
        } else {
            $this->addFlash("errors_checkSpy", "Vous ne pouvez pas espionner cette ile car elle n'appartient a aucun joueur. Vous pouvez la coloniser si vous le désirez !");
            return $this->redirectToRoute('game_map');
        }

    }*/

    /**
     * @Route("/game/attack", name="game_attack")
     * @param Request $request
     * @param ObjectManager $manager
     * @param TrainingUnitRepository $trainingUnitRepository
     * @param TrainingMachineRepository $trainingMachineRepository
     * @param BuildDefenseRepository $buildDefenseRepository
     * @param MissionRepository $missionRepository
     * @param IsleRepository $isleRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function attack(Request $request, ObjectManager $manager, TrainingUnitRepository $trainingUnitRepository,
                           TrainingMachineRepository $trainingMachineRepository, BuildDefenseRepository $buildDefenseRepository,
                           MissionRepository $missionRepository, IsleRepository $isleRepository): RedirectResponse
    {
        $session = $request->getSession();
        $speedinSec = $session->get('speedMission');
        $freight = $session->get('freight');
        $idTargetIsle = $session->get('idTargetIsle');
        $targetIsle = $isleRepository->findOneBy(['id' => $idTargetIsle]);
        $strikerIsleId = $this->getUser()->getMainIsle()->getId();
        $strikerIsle = $isleRepository->findOneBy(['id' => $strikerIsleId]);
        $unitsStriker = $session->get('checkedUnits');
        $machinesStriker = $session->get('checkedMachines');
        $targetUnits = $trainingUnitRepository->getUnitsByNombreAndIsle($targetIsle);
        $targetMachines = $trainingMachineRepository->getMachinesByNombreAndIsle($targetIsle);
        $targetDefenses = $buildDefenseRepository->getDefensesByNombreAndIsle($targetIsle);
        $warStats = $this->getWarStats($unitsStriker, $machinesStriker, $targetUnits, $targetMachines, $targetDefenses, $speedinSec);
        $warStats = $warStats['warStats'];
        MissionGenerator::generatorAttackMission($strikerIsle, $targetIsle, $warStats['strikerTroops'], $warStats['targetTroopsAndDefenses'], $freight, $speedinSec, $manager);
        $mission = $missionRepository->findBy(array(), array('id' => 'desc'), 1, 0);

        $idMission = $mission[0]->getId();
        $endDate = $mission[0]->getEndDate();
        $session->set('idMission', $idMission);
        $session->set('endDateMission', (int)$endDate);
        return $this->redirectToRoute('game_army');
    }

    /**
     * Route("/game/mission/upgradeBeforeMission/{id_building}", name="game_upgrade_building")
     */
    /*public function UpgradeBeforeMission($id_building, ObjectManager $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $isle = $this->getUser()->getMainIsle();
        $building = $manager->getRepository(BuildBuilding::class)->find($id_building);

// On vérifie que le joueur a assez de ressource pour construire le batiment
        if ($isle->getWoodStock() >= $building->getWoodCost() && $isle->getStoneStock() >= $building->getStoneCost()
            && $isle->getMetalStock() >= $building->getMetalCost()) {

// On calcul combien on doit rendre a l'utilisateur
            $resteOfWood = ($isle->getwoodStock()) - ($building->getWoodCost());
            $resteOfStone = ($isle->getStoneStock()) - ($building->getStoneCost());
            $resteOfMetal = ($isle->getMetalStock()) - ($building->getMetalCost());

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

            return $this->redirectToRoute('game_building');
        } else {
            $this->addFlash("error", "Vous n'avez pas assez de ressources pour construire ce bâtiment");
            return $this->redirectToRoute('game_building');
        }
    }*/
    /*
    // Une fois la mission créer on retire les strikerTroops de l'ile pour les laisser uniquement dans la mission
    foreach ($mission[0]->getStrikerTroops()['strikerUnits'] as $strikerUnit){
    $unitsOnIsle = $trainingUnitRepository->findOneBy(['id' => $strikerUnit[0]->getId()]);
    $nbUnitsOnIsle = $unitsOnIsle->getNombre();
    $unitsOnIsle->setNombre($nbUnitsOnIsle - $strikerUnit[1]);
    }
    foreach ($mission[0]->getStrikerTroops()['strikerMachines'] as $strikerMachine){
    $machinesOnIsle = $trainingMachineRepository->findOneBy(['id' => $strikerMachine[0]->getId()]);
    $nbMachinesOnIsle = $machinesOnIsle->getNombre();
    $machinesOnIsle->setNombre($nbMachinesOnIsle - $strikerMachine[1]);
    }

    // Quand les troupes de l'attaquant sont arrivés chez l'ennemis
    // Calcul force et vie de chaque joueur
    $strikerTroops = $mission[0]->getStrikerTroops();
    foreach ($strikerTroops['strikerUnits'] as $strikerUnit) {
    $totalStrikerDamage = $totalStrikerDamage + ($strikerUnit[0]->getDamage() * $strikerUnit[1]);
    $totalStrikerHealth = $totalStrikerHealth + ($strikerUnit[0]->getHealth() * $strikerUnit[1]);
    }
    foreach ($strikerTroops['strikerMachines'] as $strikerMachine) {
    $totalStrikerDamage = $totalStrikerDamage + ($strikerMachine[0]->getDamage() * $strikerMachine[1]);
    $totalStrikerHealth = $totalStrikerHealth + ($strikerMachine[0]->getHealth() * $strikerMachine[1]);
    }
    $totalHealthAndDamageTarget = $this->checkTargetHealthAndDamage($targetTroopsAndDefenses, $totalTargetHealth, $totalTargetDamage);
    $totalPowerTarget = ($totalHealthAndDamageTarget['totalTargetHealth'] + $totalHealthAndDamageTarget['totalTargetDamage']) / 2;
    $totalPowerStriker = ($totalStrikerDamage + $totalStrikerHealth) / 2 ;

    // Si l'attaquant gagne
    if ($totalPowerStriker > $totalPowerTarget) {
    $this->strikerWin($totalHealthAndDamageTarget, $targetTroopsAndDefenses, $strikerTroops, $totalStrikerHealth);
    }
    // Si le défenseur gagne
    if ($totalPowerTarget > $totalPowerStriker){
    $this->targetWin($totalHealthAndDamageTarget, $targetTroopsAndDefenses, $strikerTroops, $totalStrikerHealth);
    }

    return $this->redirectToRoute('game_army');
    }

    public function strikerWin($totalHealthAndDamageTarget, $targetTroopsAndDefenses, $strikerTroops, $totalStrikerHealth){
    $targetDefenses = $targetTroopsAndDefenses['targetDefenses'];
    $targetUnits = $targetTroopsAndDefenses['targetUnits'];
    $targetMachines = $targetTroopsAndDefenses['targetMachines'];
    while ($totalHealthAndDamageTarget['totalTargetHealth'] > 0) {
    if (!empty($targetDefenses)) {
    foreach ($targetDefenses as $targetDefense) {
    $nbDefenseTarget = $targetDefense->getNombre();
    $defenseTargetHealth = $targetDefense->getHealth();
    $defenseTargetDamage = $targetDefense->getDamage();
    $powerDefense = ($defenseTargetHealth + $defenseTargetDamage) / 2;

    while ($nbDefenseTarget > 0) {
    foreach ($strikerTroops as $stylesStrikerTroops) {
    foreach ($stylesStrikerTroops as $styleStrikerTroop) {

    $nbTroopStriker = $styleStrikerTroop[0]->getNombre();
    $strikerTroopDamage = $styleStrikerTroop[0]->getDamage();
    $strikerTroopHealth = $styleStrikerTroop[0]->getHealth();

    $powerTroop = ($strikerTroopDamage + $strikerTroopHealth) / 2;


    if ($powerDefense < $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $defenseTargetHealth;
    $nbDefenseTarget = $nbDefenseTarget - 1;

    } elseif ($powerDefense > $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $strikerTroopHealth;
    $nbTroopStriker = $nbTroopStriker - 1;

    } elseif ($powerDefense == $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $defenseTargetHealth;
    $nbDefenseTarget = $nbDefenseTarget - 1;
    $totalStrikerHealth = $totalStrikerHealth - $strikerTroopHealth;
    $nbTroopStriker = $nbTroopStriker - 1;
    }
    }
    }
    dd($nbDefenseTarget);

    }
    }
    }
    dd($totalHealthAndDamageTarget['totalTargetHealth']);
    if (!empty($targetUnits)) {
    foreach ($targetUnits as $targetUnit) {
    $nbUnitTarget = $targetUnit->getNombre();
    $unitTargetHealth = $targetUnit->getHealth();
    $unitTargetDamage = $targetUnit->getDamage();
    $powerUnit = ($unitTargetHealth + $unitTargetDamage) / 2;

    while ($nbUnitTarget > 0) {
    foreach ($strikerTroops as $strikerTroop) {
    $nbTroopStriker = $strikerTroop[0]->getNombre();
    $strikerTroopDamage = $strikerTroop[0]->getDamage();
    $strikerTroopHealth = $strikerTroop[0]->getHealth();
    $powerTroop = ($strikerTroopDamage + $strikerTroopHealth) / 2;
    if ($powerUnit < $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbUnitTarget = $nbUnitTarget - 1;
    } elseif ($powerUnit > $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $unitTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    } elseif ($powerUnit == $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbUnitTarget = $nbUnitTarget - 1;
    $totalStrikerHealth = $totalStrikerHealth - $unitTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    }
    }
    }
    }
    }
    if (!empty($targetMachines)) {
    foreach ($targetMachines as $targetMachine) {
    $nbMachineTarget = $targetMachine->getNombre();
    $machineTargetHealth = $targetMachine->getHealth();
    $machineTargetDamage = $targetMachine->getDamage();
    $powerMachine = ($machineTargetHealth + $machineTargetDamage) / 2;

    while ($nbMachineTarget > 0) {
    foreach ($strikerTroops as $strikerTroop) {
    $nbTroopStriker = $strikerTroop[0]->getNombre();
    $strikerTroopDamage = $strikerTroop[0]->getDamage();
    $strikerTroopHealth = $strikerTroop[0]->getHealth();
    $powerTroop = ($strikerTroopDamage + $strikerTroopHealth) / 2;
    while ($nbTroopStriker > 0) {
    if ($powerMachine < $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbMachineTarget = $nbMachineTarget - 1;

    } elseif ($powerMachine > $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $machineTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;

    } elseif ($powerMachine == $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbMachineTarget = $nbMachineTarget - 1;
    $totalStrikerHealth = $totalStrikerHealth - $machineTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    }
    }
    }
    }
    }
    }
    }
    }

    public function targetWin($totalHealthAndDamageTarget, $targetTroopsAndDefenses, $strikerTroops, $totalStrikerHealth){
    $targetDefenses = $targetTroopsAndDefenses['targetDefenses'];
    $targetUnits = $targetTroopsAndDefenses['targetUnits'];
    $targetMachines = $targetTroopsAndDefenses['targetMachines'];
    while ($totalStrikerHealth > 0) {
    foreach ($strikerTroops as $stylesStrikerTroops) {
    foreach ($stylesStrikerTroops as $styleStrikerTroop) {
    $nbTroopStriker = $styleStrikerTroop[0]->getNombre();
    $strikerTroopDamage = $styleStrikerTroop[0]->getDamage();
    $strikerTroopHealth = $styleStrikerTroop[0]->getHealth();
    $powerTroop = ($strikerTroopDamage + $strikerTroopHealth) / 2;

    while ($nbTroopStriker > 0) {
    foreach ($targetDefenses as $targetDefense) {
    $nbDefenseTarget = $targetDefense->getNombre();
    $defenseTargetHealth = $targetDefense->getHealth();
    $defenseTargetDamage = $targetDefense->getDamage();
    $powerDefense = ($defenseTargetHealth + $defenseTargetDamage) / 2;

    if ($powerDefense < $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $defenseTargetDamage;
    $nbDefenseTarget = $nbDefenseTarget - 1;

    } elseif ($powerDefense > $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $defenseTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;

    } elseif ($powerDefense == $powerTroop) {

    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbDefenseTarget = $nbDefenseTarget - 1;
    $totalStrikerHealth = $totalStrikerHealth - $defenseTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    }
    }
    foreach ($targetUnits as $targetUnit) {
    $nbUnitTarget = $targetUnit->getNombre();
    $unitTargetHealth = $targetUnit->getHealth();
    $unitTargetDamage = $targetUnit->getDamage();
    $powerUnit = ($unitTargetHealth + $unitTargetDamage) / 2;

    if ($powerUnit < $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $unitTargetDamage;
    $nbUnitTarget = $nbUnitTarget - 1;

    } elseif ($powerUnit > $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $unitTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    } elseif ($powerUnit == $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbUnitTarget = $nbUnitTarget - 1;
    $totalStrikerHealth = $totalStrikerHealth - $unitTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    }
    }
    foreach ($targetMachines as $targetMachine) {
    $nbMachineTarget = $targetMachine->getNombre();
    $machineTargetHealth = $targetMachine->getHealth();
    $machineTargetDamage = $targetMachine->getDamage();
    $powerMachine = ($machineTargetHealth + $machineTargetDamage) / 2;

    if ($powerMachine < $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $machineTargetDamage;
    $nbMachineTarget = $nbMachineTarget - 1;

    } elseif ($powerMachine > $powerTroop) {
    $totalStrikerHealth = $totalStrikerHealth - $machineTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    } elseif ($powerMachine == $powerTroop) {
    $totalHealthAndDamageTarget['totalTargetHealth'] = $totalHealthAndDamageTarget['totalTargetHealth'] - $strikerTroopDamage;
    $nbMachineTarget = $nbMachineTarget - 1;
    $totalStrikerHealth = $totalStrikerHealth - $machineTargetDamage;
    $nbTroopStriker = $nbTroopStriker - 1;
    }
    }
    }
    }
    }
    }
    return $this->redirectToRoute('game_army');
    }*/
}