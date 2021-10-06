<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Isle;
use App\Entity\User;
use App\Repository\IsleRepository;
use App\Repository\MessageRepository;
use App\Repository\TrainingMachineRepository;
use App\Repository\TrainingUnitRepository;
use App\Repository\UnitRepository;
use App\Repository\MachineRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class GameController extends AbstractController
{

    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
        return $this->redirectToRoute('game_general_view');
    }


    /*
                            ****************************************************
                            ****************************************************
                            ******************* GENERAL VIEW *******************
                            ****************************************************
                            ****************************************************
    */

    /**
     * @Route("/game/general_view", name="game_general_view")
     */
    public function generalView()
    {
        return $this->render('game/generalView.html.twig');
    }


    /*
                            ****************************************************
                            ****************************************************
                            ******************* EVOLUTION  *********************
                            ****************************************************
                            ****************************************************
     */

    /**
     * @Route("/game/evolution", name="game_evolution")
     */
    public function evolution()
    {

        return $this->render('game/evolution.html.twig');
    }


    /*
                            ****************************************************
                            ****************************************************
                            ******************* RANKING ************************
                            ****************************************************
                            ****************************************************
     */

    /**
     * @Route("/game/ranking", name="game_ranking")
     */
    public function classement(IsleRepository $isleRepository)
    {
        return $this->render('game/ranking.html.twig', [
            'users' => $isleRepository->getUserByPowerPointOfTotalIsle()
        ]);
    }


    /*
                            ****************************************************
                            ****************************************************
                            ******************* ACCOUNT_OPTION *****************
                            ****************************************************
                            ****************************************************
     */

    /**
     * @Route("/game/account", name="game_account")
     */
    public function accountOption(Request $req, ObjectManager $manager)
    {   // Vérifie si un nouveau username existe dans le champ
        if ($username = $req->request->get("newUsername")) {

            $id = $this->getUser()->getId();

            $user = $manager->getRepository(User::class)->find($id);
            // Si un champ existe, on modifie le pseudo
            $user->setUsername($username);
            $manager->flush();
        } // Sinon on reprend les infos telles quelles
        else {
            $user = $this->getUser();
        }
        return $this->render('game/account.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/game/checkPreferenceSpy", name="checkPreferenceSpy")
     */
    public function preference(Request $request, TrainingUnitRepository $trainingUnitRepository, TrainingMachineRepository $trainingMachineRepository,
                               ObjectManager $manager, UnitRepository $unitRepository, MachineRepository $machineRepository)
    {
        $user = $this->getUser();
        if ($request->request->has('troupeEspionnage') && $request->request->has('nbTroupeEspionnage')) {
            $troupeEspionnage = $request->request->get('troupeEspionnage');
            $nbTroupeEspionnage = $request->request->get('nbTroupeEspionnage');
            $strikerIsle = $user->getMainIsle();
            if ($troupeEspionnage == "archeologue") {
                $archeologue = $unitRepository->findOneBy(['name' => 'Archéologue']);
                $strikerArcheologue = $trainingUnitRepository->findOneBy(['isle' => $strikerIsle,
                    'unit' => $archeologue
                ]);
                $user->setPreferenceUnitSpy($strikerArcheologue);
                $user->setPreferenceMachineSpy(null);
                $manager->persist($user);
                $manager->flush($user);

            }
            if ($troupeEspionnage == "DroneEspion") {
                $droneEspion = $machineRepository->findOneBy(['name' => 'Drone espion']);
                $strikerDroneEspion = $trainingMachineRepository->findOneBy(['isle' => $strikerIsle,
                    'machine' => $droneEspion
                ]);
                $user->setPreferenceMachineSpy($strikerDroneEspion);
                $user->setPreferenceUnitSpy(null);
                $manager->persist($user);
                $manager->flush($user);

            }
            if ($troupeEspionnage != "DroneEspion" && $troupeEspionnage != "archeologue") {
                $this->addFlash("errorPreferenceSpy", "Ce choix de troupe n'existe pas , il y a un problème !");
                return $this->redirectToRoute('game_account');
            }
            if (htmlspecialchars(is_numeric($nbTroupeEspionnage))) {
                if ($nbTroupeEspionnage < 1 || $nbTroupeEspionnage > 20) {
                    $this->addFlash("errorPreferenceSpy", "Il faut entrer un nombre entier entre 1 et 20 dans ce champ ! Reesayer");
                    return $this->redirectToRoute('game_account');
                } else {
                    $user->setNbPreferenceSpy($nbTroupeEspionnage);
                    $manager->persist($user);
                    $manager->flush($user);
                }
            } else {
                $this->addFlash("errorPreferenceSpy", "Nous n'avons pas compris ! Reesayer");
                return $this->redirectToRoute('game_account');
            }

        }
        $this->addFlash("succesPreferenceSpy", "Votre préférence a bien était pris en compte");
        return $this->redirectToRoute('game_account');
    }






    /*
                            ****************************************************
                            ****************************************************
                            ******************* COORDINATE *********************
                            ****************************************************
                            ****************************************************
     */

    /**
     * @Route("/game/coordinate", name="game_map")
     */
    public function coordinate(Session $session, IsleRepository $isleRepository, Request $request)
    {
        // Vérification valeur formulaire navigation coordonnées (coordinate.html.twig)
        if ($request->request->has('longitude') && $request->request->has('latitude')) {
            $longitudeSubmit = $request->request->get('longitude');
            $latitudeSubmit = $request->request->get('latitude');

            return $this->render('game/coordinate.html.twig', [
                'isles' => $isleRepository->TenIsleWithUsername($longitudeSubmit, $latitudeSubmit),
                'longitude' => $longitudeSubmit,
                'latitude' => $latitudeSubmit
            ]);
        } // Si une session existe ( si le joueur etait sur une coordonnée précise , le remet dessus )
        elseif ($session->has('targetLongitude') && $session->has('targetLatitude')) {
            $longitude = $session->get('targetLongitude');
            $latitude = $session->get('targetLatitude');
            $session->remove('targetLongitude');
            $session->remove('targetLatitude');
            return $this->render('game/coordinate.html.twig', [
                'isles' => $isleRepository->TenIsleWithUsername($longitude, $latitude),
                'longitude' => $longitude,
                'latitude' => $latitude
            ]);
        } // Si elles n'existent pas on prend les valeurs de l'ile actuel
        else {
            $user = $this->getUser();
            $longitude = $user->getMainIsle(Isle::class)->getLongitude();
            $latitude = $user->getMainIsle(Isle::class)->getLatitude();

            return $this->render('game/coordinate.html.twig', [
                'isles' => $isleRepository->TenIsleWithUsername($longitude, $latitude),
                'longitude' => $longitude,
                'latitude' => $latitude
            ]);
        }
    }

    /*
                               ****************************************************
                               ****************************************************
                               ******************* HELP *************************
                               ****************************************************
                               ****************************************************
    */

    /**
     * @Route("/game/help", name="game_help")
     */
    public function gameHelp(){
        return $this->render("game/help.html.twig");
    }


    /*
                                ****************************************************
                                ****************************************************
                                ******************* AUTRES *************************
                                ****************************************************
                                ****************************************************
     */


    /**
     * @param $totalCost
     * @return float|int
     */
    public function upPowerPoint($totalCost)
    {
        if ($totalCost < 100 && $totalCost > 0) {
            $upPowerPoint = 1;
            return $upPowerPoint;
        }

        if ($totalCost > 100) {
            $upPowerPoint = $totalCost / 100;
            return $upPowerPoint;
        }
    }

    /**
     * @Route("/game/updateTimeMission", name="game_updateTimeMission")
     */
    public function updateTimeMission(Request $request){
        if ($request->query->has('endDate')){
            $now = time();
            $endDate = $request->query->get('endDate');
            $diff = $endDate - $now;
            $session = $request->getSession();
            $session->set('timeMission', (int)$diff);
            return new Response("ok");
        }
        else{
            return new Response("pasbon");
        }
    }
    /**
     * @Route("/game/ajaxGetSession", name="game_getSessionAjax")
     */
    public function getSessionAjax(Request $request){
        $session = $request->getSession();
        $speedMissionInSec = $session->get('speedMissionInSec');
        return new Response($speedMissionInSec);
    }

    /**
     * @Route("/game/ajaxSetSession", name="game_setSessionAjax", methods={"GET"})
     */
    public function setSessionAjax(Request $request){
        $session = $request->getSession();
        $newSpeed = $request->query->get('time');
        $session->set('speedMissionInSec', (int)$newSpeed);
        return new Response('true');

    }



    /**
     * @Route("/game/updateRessource", name="game_update_ressource")
     */
    public function updateSession(Request $request){
        $wood = $request->query->get('newwood');
        $stone = $request->query->get('newstone');
        $metal = $request->query->get('newmetal');
        $oil = $request->query->get('newoil');
        $session = $request->getSession();
        $session->set('wood', $wood);
        $session->set('stone', $stone);
        $session->set('metal', $metal);
        $session->set('oil', $oil);

        return new Response("true");
    }


    public function checkUserIsle($isle){

        if($this->getUser() !== $isle->getUser()){
            return false;
        }
        return true;
    }


    public function formatTargetTroopsAndDefensesForDatabase($targetUnits, $targetMachines, $targetDefenses){
        $tabTargetTroopsAndDefensesFormat = [];

        if (!empty($targetUnits)) {
            foreach ($targetUnits as $targetUnit) {
                $nameUnit = $targetUnit->getUnit()->getName();
                $nombreUnits = $targetUnit->getNombre();
                $unit = $nameUnit . ":" . $nombreUnits;
                array_push($tabTargetTroopsAndDefensesFormat, $unit);
            }
        }
        if (!empty($targetMachines)) {
            foreach ($targetMachines as $targetMachine) {
                $nameMachine = $targetMachine->getMachine()->getName();
                $nombreMachines = $targetMachine->getNombre();
                $machine = $nameMachine . ":" . $nombreMachines;
                array_push($tabTargetTroopsAndDefensesFormat, $machine);
            }
        }
        if (!empty($targetDefenses)) {
            foreach ($targetDefenses as $targetDefense) {
                $nameDefense = $targetDefense->getDefense()->getName();
                $nombreDefenses = $targetDefense->getNombre();
                $defense = $nameDefense . ":" . $nombreDefenses;
                array_push($tabTargetTroopsAndDefensesFormat, $defense);
            }
        }
        return $tabTargetTroopsAndDefensesFormat;
    }

    public function checkTotalFreightCapacity($units, $machines, TrainingUnitRepository $trainingUnitRepository, TrainingMachineRepository $trainingMachineRepository){

        $tabFreightCapacity = [];

        foreach ($units as $unit) {
            $id = $unit[0]->getId();
            $dataUnit = $trainingUnitRepository->findOneBy(['id' => $id]);
            if (is_int($unit[1]) <= $dataUnit->getNombre()) {
                array_push($tabFreightCapacity, ($dataUnit->getFreightCapacity() * $unit[1]));
            } else {
                $this->addFlash('errorMission', "Vous n'avez pas (ou plus) les unitées sélectionnées. Veuillez vérifié et réessayer.");
                return $this->redirectToRoute('game_mission');
            }
        }
        foreach ($machines as $machine) {
            $id = $machine[0]->getId();
            $dataMachine = $trainingMachineRepository->findOneBy(['id' => $id]);
            if (is_int($machine[1]) <= $dataMachine->getNombre()) {
                array_push($tabFreightCapacity, ($dataMachine->getFreightCapacity() * $machine[1]));
            } else {
                $this->addFlash('errorMission', "Vous n'avez pas (ou plus) les machines sélectionnées. Veuillez vérifié et réessayer.");
                return $this->redirectToRoute('game_mission');
            }
        }
        $totalFreight = array_sum($tabFreightCapacity);
        return $totalFreight;
    }

    public function checkPreferenceSpyUser($striker, TrainingMachineRepository $trainingMachineRepository, TrainingUnitRepository $trainingUnitRepository){

        if ($striker->getPreferenceUnitSpy() == !null) {
            $preferenceUnitSpy = $trainingUnitRepository->findOneBy(['id' => $striker->getPreferenceUnitSpy()]);
            $nbPreferenceSpy = $striker->getNbPreferenceSpy();
            $nbMaxUnitSpy = $preferenceUnitSpy->getNombre();
            $unitName = $preferenceUnitSpy->getUnit()->getName();
            if ($nbPreferenceSpy > $nbMaxUnitSpy){
                $this->addFlash('errors_checkSpy',"Vous avez choisi d'envoyer $nbPreferenceSpy $unitName(s), malheuresement vous n'en disposez que de $nbMaxUnitSpy ");
                return $this->redirectToRoute('game_account');
            }
            else {
                $preferenceUnitSpy = [
                    'nomUnit' => $unitName,
                    'nombreUnit' => $nbPreferenceSpy
                    ];
            }
        }
        if ($striker->getPreferenceMachineSpy() == !null) {
            $preferenceMachineSpy = $trainingMachineRepository->findOneBy(['id' => $striker->getPreferenceMachineSpy()]);
            $nbPreferenceSpy = $striker->getNbPreferenceSpy();
            $nbMaxMachineSpy = $preferenceMachineSpy->getNombre();
            $machineName = $preferenceMachineSpy->getMachine()->getName();
            if ($nbPreferenceSpy > $nbMaxMachineSpy){
                $this->addFlash('errors_checkSpy',"Vous avez choisi d'envoyer $nbPreferenceSpy $machineName(s), malheuresement vous n'en disposez que de $nbMaxMachineSpy ");
                return $this->redirectToRoute('game_map');
            }
            else {
                $preferenceMachineSpy = [
                    'nomMachine' => $machineName,
                    'nombreMachine' => $nbPreferenceSpy
                    ];
            }
        }
        if (isset($preferenceMachineSpy)) {
            $preferenceSpy = $preferenceMachineSpy;
        }
        if (isset($preferenceUnitSpy)){
            $preferenceSpy = $preferenceUnitSpy;
        }
        return $preferenceSpy;
    }


    public function checkTargetHealthAndDamage($targetTroopsAndDefenses, $totalTargetHealth, $totalTargetDamage){
        $targetDefenses = $targetTroopsAndDefenses['targetDefenses'];
        $targetUnits = $targetTroopsAndDefenses['targetUnits'];
        $targetMachines = $targetTroopsAndDefenses['targetMachines'];
        if (!empty($targetDefenses)) {
            $totalTargetDefensesDamage = 0;
            $totalTargetDefensesHealth = 0;
            foreach ($targetDefenses as $targetDefense) {
                $totalTargetDefensesDamage = $totalTargetDefensesDamage + ($targetDefense->getDamage() * $targetDefense->getNombre());
                $totalTargetDefensesHealth = $totalTargetDefensesHealth + ($targetDefense->getHealth() * $targetDefense->getNombre());
            }
            $totalTargetDamage = $totalTargetDamage + $totalTargetDefensesDamage;
            $totalTargetHealth = $totalTargetHealth + $totalTargetDefensesHealth;
        }
        if (!empty($targetUnits)) {
            $totalTargetUnitsDamage = 0;
            $totalTargetUnitsHealth = 0;
            foreach ($targetUnits as $targetUnit) {
                $totalTargetUnitsDamage = $totalTargetUnitsDamage + ($targetUnit->getDamage() * $targetUnit->getNombre());
                $totalTargetUnitsHealth = $totalTargetUnitsHealth + ($targetUnit->getHealth() * $targetUnit->getNombre());
            }
            $totalTargetDamage = $totalTargetDamage + $totalTargetUnitsDamage;
            $totalTargetHealth = $totalTargetHealth + $totalTargetUnitsHealth;
        }
        if (!empty($targetMachines)) {
            $totalTargetMachinesDamage = 0;
            $totalTargetMachinesHealth = 0;
            foreach ($targetMachines as $targetMachine) {
                $totalTargetMachinesDamage = $totalTargetMachinesDamage + ($targetMachine->getDamage() * $targetMachine->getNombre());
                $totalTargetMachinesHealth = $totalTargetMachinesHealth + ($targetMachine->getHealth() * $targetMachine->getNombre());
            }
            $totalTargetDamage = $totalTargetDamage + $totalTargetMachinesDamage;
            $totalTargetHealth = $totalTargetHealth + $totalTargetMachinesHealth;

        }
        return [
            'totalTargetDamage' => $totalTargetDamage,
            'totalTargetHealth' => $totalTargetHealth,
        ];
    }


    /*
                            ****************************************************
                            ****************************************************
                            ******************* MESSAGES *********************
                            ****************************************************
                            ****************************************************
     */

    /**
     * @Route("/game/message", name="game_message")
     */
    public function message(MessageRepository $messageRepository){
        $user = $this->getUser();
        return $this->render('/game/message/message.html.twig', [
            'messages' => $messageRepository->getAllMessagesByUser($user)
        ]);

    }

    /**
     * @Route("/game/message/{id_message}", name="message_show", methods={"GET"})
     */
    public function showMessage($id_message, MessageRepository $messageRepository, ObjectManager $manager)
    {
        $user = $this->getUser();
        $user->setNbUnreadMessage($user->getNbUnreadMessage() - 1);

        $manager->persist($user);
        $manager->flush();
        if ($user->getNbUnreadMessage() <= 1){
            $user->setNbUnreadMessage(0);
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('game/message/show_message.html.twig', [
            'message' => $messageRepository->find($id_message),
        ]);
    }
}
