<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Isle;
use App\Repository\IsleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
 */
class MissionController extends AbstractController
{

    public function checkTargetCoordinate(Request $request)
    {
        $check = false;
        // On check les coordonnées recu en post
        if ($request->request->has('longitude')) {
            // On convertis la post en nombre
            $longitude = (int)$request->request->get('longitude');
            // on verifie la longitude
            if ($longitude > 9 || $longitude < 0) {
                $this->addFlash('errorCheckMission', 'Cette longitude n\'existe pas, veuillez vérifier.');
                return $this->render('game/mission.html.twig');
            }
            $longitudeChecked = $longitude;
        } // si la post "longitude n'existe pas"
        else {
            $this->addFlash('errorCheckMission', 'La longitude de votre cible doit être saisie obligatoirement afin de continuer la mission.');
            return $this->render('game/mission.html.twig');
        }
        // on procede de la même maniere pour la latitude
        if ($request->request->has('latitude')) {
            $latitude = (int)$request->request->get('latitude');
            if ($latitude > 300 || $latitude < 0) {
                $this->addFlash('errorCheckMission', 'Cette latitude n\'existe pas, veuillez vérifier.');
                return $this->render('game/mission.html.twig');
            }
            $latitudeChecked = $latitude;
        } else {
            $this->addFlash('errorCheckMission', 'La latitude de votre cible doit être saisie obligatoirement afin de continuer la mission.');
            return $this->render('game/mission.html.twig');
        }
        // et pour la position
        if ($request->request->has('position')) {
            $position = (int)$request->request->get('position');
            //dd($position);
            if ($position > 10 || $position < 1) {
                $this->addFlash('errorCheckMission', 'Cette position n\'existe pas, veuillez vérifier.');
                return $this->render('game/mission.html.twig');
            }
            $positionChecked = $position;
        } else {
            $this->addFlash('errorCheckMission', 'La position de votre cible doit être saisie obligatoirement afin de continuer la mission.');
            return $this->render('game/mission.html.twig');
        }

        //Si longitude, latitude et position ont passer les test,
        if (isset($longitudeChecked, $latitudeChecked, $positionChecked)) {
            $targetIsle = [$longitude, $latitude, $position];
            $session = $request->getSession();
            $session->set('coordinate', $targetIsle);
            $check = true;
            return $check;
        }
        $this->addFlash('errorCheckMission', 'Un probleme a eu lieu avec les coordonnées de votre cible. Veuillez réessayer.');
        return $this->render('game/mission.html.twig');
    }

    public function checkRessourceSubmited($maxFreightCapacity, Request $request, Isle $strikerIsle)
    {

        if ($request->request->has('woodFreight')) {
            $wood = (int)$request->request->get('woodFreight');
            if ($wood > $strikerIsle->getWoodStock()) {
                $this->addFlash('errorCheckMission', 'Vous ne pouvez pas envoyer autant de bois car vous n\'en n\'avez pas autant.');
                return $this->render('game/mission.html.twig');
            }
            if ($wood <= 0) {
                $woodChecked = 0;
            } else {
                $woodChecked = $request->request->get('woodFreight');
            }
        } else {
            $woodChecked = 0;
        }


        if ($request->request->has('stoneFreight')) {
            $stone = (int)$request->request->get('stoneFreight');
            if ($stone > $strikerIsle->getStoneStock()) {
                $this->addFlash('errorCheckMission', 'Vous ne pouvez pas envoyer autant de pierre car vous n\'en n\'avez pas autant.');
                return $this->render('game/mission.html.twig');
            }
            if ($stone <= 0) {
                $stoneChecked = 0;
            } else {
                $stoneChecked = $stone;
            }
        } else {
            $stoneChecked = 0;
        }

        if ($request->request->has('metalFreight')) {
            $metal = (int)$request->request->get('metalFreight');
            if ($metal > $strikerIsle->getMetalStock()) {
                $this->addFlash('errorCheckMission', 'Vous ne pouvez pas envoyer autant de métal car vous n\'en n\'avez pas autant.');
                return $this->render('game/mission.html.twig');
            }
            if ($metal <= 0) {
                $metalChecked = 0;
            } else {
                $metalChecked = $metal;
            }
        } else {
            $metalChecked = 0;
        }

        if ($request->request->has('oilFreight')) {
            $oil = $request->request->get('oilFreight');
            if ($oil > $strikerIsle->getoilStock()) {
                $this->addFlash('errorCheckMission', 'Vous ne pouvez pas envoyer autant de carburant car vous n\'en n\'avez pas autant.');
                return $this->render('game/mission.html.twig');
            }
            if ($oil <= 0) {
                $oilChecked = 0;
            } else {
                $oilChecked = $oil;
            }
        } else {
            $oilChecked = 0;
        }
        $totalChecked = $woodChecked + $stoneChecked + $metalChecked + $oilChecked;

        if ($totalChecked > $maxFreightCapacity) {
            $this->addFlash('errorCheckMission', 'Vous ne pouvez pas envoyer autant de ressource car vous n\'en avec pas la capicité. Il vous faut plus de capacité de transport. carburant car vous n\'en n\'avez pas autant.');
            return $this->render('game/mission.html.twig');
        }

        $availableFreight = $maxFreightCapacity - $totalChecked;
        $ressourcesSumitedChecked = [
            'freightSubmited' =>
                [
                    'wood' => $woodChecked,
                    'stone' => $stoneChecked,
                    'metal' => $metalChecked,
                    'oil' => $oilChecked
                ],
            'availableFreight' => $availableFreight
        ];

        return $ressourcesSumitedChecked;
    }

    /**
     * @Route("/game/mission", name="game_check_mission")
     * @param Request $request
     * @param IsleRepository $isleRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function CheckMission(Request $request, IsleRepository $isleRepository)
    {
        $striker = $this->getUser();
        $strikerIsle = $striker->getMainIsle();
        $session = $request->getSession();
        if ($request->request->has('speedMission') && $request->request->has('longitude') &&
            $request->request->has('latitude') && $request->request->has('position') && $request->request->get('speedMission')) {
            $maxFreightCapacity = $session->get('maxFreight');
            $speedMissionInSec = $request->request->get('speedMission');
            $session->set('speedMission', (int)$speedMissionInSec);
            $ressourceCheckedSubmited = $this->checkRessourceSubmited($maxFreightCapacity, $request, $strikerIsle);
            $session->set('freight', $ressourceCheckedSubmited);
            $session->set('strikerIsle', $strikerIsle);
            // Si il n'y a pas eu d'erreur pendant le checkCoordinate
            if ($this->checkTargetCoordinate($request) === true) {
                $coordinate = $session->get('coordinate');
                $targetIsle = $isleRepository->getIsleByCoordinate($coordinate[0], $coordinate[1], $coordinate[2]);
                $idTargetIsle = $targetIsle->getId();
                $session->set('idTargetIsle', $idTargetIsle);
                // Si l'user de l'ile n'est pas nul (verifie si l'ile appartient ou non a quelqu'un
                if (!$targetIsle->getUser() === false) {
                    // Si l'ordre de mission a étais définit en post
                    if ($request->request->has('choiceMission')) {
                        //Puis on verifie quel ordre de mission a etais définit
                        $choice = $request->request->get('choiceMission');
                        switch ($choice) {
                            case 'Attaquer':
                                return $this->redirectToRoute('game_attack');
                                break;
                            case 'Espionner':
                                return $this->redirectToRoute('game_spy');
                                break;
                            case 'Transporter':
                                return $this->redirectToRoute('game_transport');
                                break;
                            default:
                                $this->addFlash('errorCheckMission', 'Un probleme a eu lieu avec votre ordre de mission. Veuillez réessayer.');
                                return $this->redirectToRoute('game_check_mission');
                        }
                    } else {
                        $this->addFlash('errorCheckMission', 'L\'ordre de mission doit etre renseigner obligatoirement. Veuillez réessayer.');
                        return $this->redirectToRoute('game_check_mission');
                    }
                } else {
                    $this->addFlash('errorCheckMission', 'Cette île n\'appartient a aucun joueur !.');
                    return $this->redirectToRoute('game_check_mission');
                }
            } else {
                $this->addFlash('errorCheckMission', 'Les coordonnées saisi doivent être des nombres entier. Veuillez réessayer.');
                return $this->redirectToRoute('game_check_mission');
            }
        } else {
            $this->addFlash('errorCheckMission', 'La position , longitude , latitude de la cible doit etre saisie obligatoirement.La vitesse ne peut pas être null. Veuillez réessayer.');
            return $this->render('game/mission.html.twig');
        }

    }
}