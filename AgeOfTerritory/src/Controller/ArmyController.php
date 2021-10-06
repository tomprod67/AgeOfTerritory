<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\TrainingMachineRepository;
use App\Repository\TrainingUnitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class ArmyController extends AbstractController
{

    /**
     * @Route("/game/army", name="game_army")
     * @param TrainingUnitRepository $trainingUnitRepository
     * @param TrainingMachineRepository $trainingMachineRepository
     * @return Response
     */
    public function army(TrainingUnitRepository $trainingUnitRepository, TrainingMachineRepository $trainingMachineRepository): Response
    {
        $isle = $this->getUser()->getMainIsle();
        return $this->render('game/army.html.twig',
            [
                'machines' => $trainingMachineRepository->getAllMachinesByIsle($isle),
                'units' => $trainingUnitRepository->getAllUnitsByIsle($isle),
            ]
        );
    }

    /**
     * @Route("/game/army/check", name="game_army_check")
     */
    public function checkArmyForMission(Request $request, TrainingMachineRepository $trainingMachineRepository,
                                        TrainingUnitRepository $trainingUnitRepository)
    {
        $unitsChecked = [];
        $machinesChecked = [];
        $maxFreightSubmited = 0;
        $totalSpeed = 0;
        $nbTotalTroop = 0;

        // On vérifie si il y a des unités en Post (suite au formulaire de "army.html.twig")
        if ($request->request->has('units')) {
            // Si il y en a on les enferment dans une variable
            $unitsSubmited = $request->request->get('units');
            // Puis on les test une par une
            foreach ($unitsSubmited as $idUnitSubmited => $nbUnitSubmited) {
            // on néttois les données recus (Integer positif)
                $numberSubmited = is_int((int)$nbUnitSubmited);
                if (!$numberSubmited) {
                    $this->addFlash('errorCheckArmy', 'Le nombre d\'unité(s) doit etre un nombre entier !');
                    return $this->redirectToRoute('game_army');
                }
                // on verifie si l'utilisateur n'a pas choisi un nombre trop elevé (nbmax unit)
                $maxUnit = $trainingUnitRepository->find($idUnitSubmited)->getNombre();
                if ($numberSubmited > $maxUnit) {
                    $this->addFlash('errorCheckArmy', 'Vous n\avez pas autant d\'unités que ça !');
                    return $this->redirectToRoute('game_army');
                }
                // ou "0"
                if ($numberSubmited < 1) {
                    $this->addFlash('errorCheckArmy', 'Vous devez renseigné un nombre entier, "0" n\'est pas consideré comme un nombre valable.');
                    return $this->redirectToRoute('game_army');
                }

                /* une fois nettoyer on incrémente la variable "$maxFreightSubmited" avec les donnée reçu, puis on met
                l'unité verifiée et nettoyée a l'interieur du tableau "$unitChecked
                */
                $unit = $trainingUnitRepository->find($idUnitSubmited);
                $maxFreightSubmited += ($unit->getFreightCapacity() * $numberSubmited);
                $totalSpeed += $unit->getSpeed() * $numberSubmited;
                $nbTotalTroop += $numberSubmited;

                $oneUnit = ['unit' => $unit, 'nbUnit' => $nbUnitSubmited];
                $unitsChecked[$unit->getUnit()->getName()] = $oneUnit;
            }
        }
        // On procède de la même manière pour les machines
        if ($request->request->has('machines')) {
            $machinesSubmited = $request->request->get('machines');
            foreach ($machinesSubmited as $idMachineSubmited => $nbMachineSubmited) {
                // on néttois les données recus
                $numberSubmited = is_int((int)$nbMachineSubmited);
                if (!$numberSubmited) {
                    $this->addFlash('errorCheckArmy', 'Le nombre de machine(s) doit etre un nombre entier !');
                    return $this->redirectToRoute('game_army');
                }
                // on verifie si l'utilisateur n'a pas choisi un nombre trop elevé (nbmax unit)
                $maxMachine = $trainingMachineRepository->find($idMachineSubmited)->getNombre();
                if ($numberSubmited > $maxMachine) {
                    $this->addFlash('errorCheckArmy', "Vous n'avez pas autant de machines que ça !");
                    return $this->redirectToRoute('game_army');
                }
                // ou 0
                if ($numberSubmited < 1) {
                    $this->addFlash('errorCheckArmy', 'Le nombre "0" ou négatif n\'est pas une valeur acceptable dans ce champ.');
                    return $this->redirectToRoute('game_army');
                }

                /* une fois nettoyer on incrémente la variable "$maxFreightSubmited" avec les donnée reçu, puis on met
                l'unité verifiée et nettoyée a l'interieur du tableau "$unitChecked
                */
                $machine = $trainingMachineRepository->find($idMachineSubmited);
                $maxFreightSubmited += $machine->getFreightCapacity();
                $totalSpeed += $machine->getSpeed() * $numberSubmited;
                $nbTotalTroop += $numberSubmited;
                $oneMachine = ['machine' => $machine, 'nbMachine' => $nbMachineSubmited];
                $machinesChecked[$machine->getMachine()->getName()] = $oneMachine;
            }
        }
       
        $session = $request->getSession();

        /* On vérifie si les tableau "checked" sont vide avant des les mettre en session, si aucun des 2 n'existent
        on renvoi une erreur sinon on met les tableau qui ne sont pas vide en session pour la prochaine etape
        */
        if (!empty($machinesChecked)) {
            $session->set('checkedMachines', $machinesChecked);
        }
        if (!empty($unitsChecked)) {
            $session->set('checkedUnits', $unitsChecked);
        }
        if (empty($unitsChecked) && empty($machinesChecked)) {
            $this->addFlash('errorCheckArmy', 'Un problème est survenu pendant la vérification du nombre d\'unité(s) ou de machine(s) envoyées. veuillez réessayer !');
            return $this->redirectToRoute('game_army');
        }
        // Calcul vitesse moyenne + algo vitesse
        $averageSpeed = round($totalSpeed / $nbTotalTroop, 2);
        $speed = explode('.', (string)$averageSpeed);
        $speedInSsec = (int)$speed[0] * 60;

        $session->set('maxFreight', $maxFreightSubmited);
        $session->set('speedMissionInSec', $speedInSsec);
        $choices = ['Attaquer', 'Espionner', 'Transporter'];
        $session->set('choices', $choices);
        return $this->render('game/mission.html.twig', [
            'units' => $session->get('checkedUnits'),
            'machines' => $session->get('checkedMachines'),
            'choices' => $session->get('choices'),
            'maxFreight' => $session->get('maxFreight'),
        ]);
    }
}