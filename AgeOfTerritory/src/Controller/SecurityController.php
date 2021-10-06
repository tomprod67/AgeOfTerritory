<?php

namespace App\Controller;
use App\Entity\BuildBuilding;
use App\Entity\Building;
use App\Entity\BuildingGenerator;
use App\Entity\MessageGenerator;
use App\Entity\TechnologyGenerator;
use App\Entity\UnitGenerator;
use App\Entity\MachineGenerator;
use App\Entity\DefenseGenerator;
use App\Entity\Unit;
use App\Entity\Machine;
use App\Entity\Defense;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Isle;
use App\Entity\SearchTechnology;
use App\Entity\Technology;
use App\Form\RegistrationType;
use App\Repository\IsleRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Form\ForgottenPasswordType;
use App\Form\ResetPasswordType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Form\ChangePasswordType;
use ReCaptcha\ReCaptcha;


class SecurityController extends AbstractController
{
    /**
     * @route("/home", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();
        // On creer le forumulaire d'inscription
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        $reCaptcha = new ReCaptcha('6Ld2qLwUAAAAAD3XsOuLa1bt88mJ6ngaORlwaLXZ');
        $resp = $reCaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

        // On fait le traitement du forumulaire d'inscription
        if ($resp->isSuccess()) {

            if($form->isSubmitted() && $form->isValid()) {
                // Si tout est bon, on lui attribut une île au hasard a l'utilisateur
                // En verifiant que l'ile est bien libre
                do {
                    $randomIsleId = random_int(0, 30100);
                    $isle = $this->getDoctrine()->getRepository(Isle::class)->find($randomIsleId);

                } while ($isle->getName() !== "Emplacement Libre");
                // Si l'ile est libre on lui génére des ressource
                switch($isle->getPosition()){
                    case 1:
                        $isle->setPicture("île1.png");
                        break;
                    case 2:
                        $isle->setPicture("île2.png");
                        break;
                    case 3:
                        $isle->setPicture("île3.png");
                        break;
                    case 4:
                        $isle->setPicture("île4.png");
                        break;
                    case 5:
                        $isle->setPicture("île5.png");
                        break;
                    case 6:
                        $isle->setPicture("île6.png");
                        break;
                    case 7:
                        $isle->setPicture("île7.png");
                        break;

                    case 8:
                        $isle->setPicture("île8.png");
                        break;
                    case 9:
                        $isle->setPicture("île9.png");
                        break;
                    case 10:
                        $isle->setPicture("île1.png");
                        break;
                }
                $isle->setName('Ile Principale');
                $isle->setWoodStock(5000);
                $isle->setStoneStock(5000);
                $isle->setMetalStock(5000);
                $isle->setOilStock(500);
                $isle->setPowerPoint(0);
                $isle->setWoodProd(15);
                $isle->setStoneProd(10);
                $isle->setMetalProd(0);
                $isle->setOilProd(0);
                $admin = $manager->getRepository(User::class)->find(60);



                //On relie l'ile et l'utilisateur et on hash son od de passe
                $user->setMainIsle($isle);
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setRoles(['ROLE_USER']);
                $user->setRecordDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

                $manager->persist($user);
                $manager->persist($isle);
                $manager->flush();
                // On affecte un username par défault a l'utilisateur

                $user = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
                $isle = $user->getMainIsle();
                $user->setUsername("Commandant" . $user->getId());
                $isle->setUser($user);

                // On genere les technologies
                $repoTechnology = $this->getDoctrine()->getRepository(Technology::class);
                $technologies = $repoTechnology->findAll();
                $nomsTechniques = TechnologyGenerator::generatorTechnology();

                $i = 0;
                foreach ($technologies as $technology) {
                    $path = "generator" . $nomsTechniques[$i];
                    TechnologyGenerator::$path($isle, $manager, $technology);
                    $i++;
                }

                // Puis les batiments
                $repoBuilding = $this->getDoctrine()->getRepository(Building::class);
                $buildings = $repoBuilding->findAll();
                $nomsBuildings = BuildingGenerator::generatorBuilding();

                $j = 0;
                foreach ($buildings as $building) {
                    $path = "generator" . $nomsBuildings[$j];
                    BuildingGenerator::$path($isle, $manager, $building);
                    $j++;
                }

                // Puis les unité
                $repoUnit = $this->getDoctrine()->getRepository(Unit::class);
                $units = $repoUnit->findAll();
                $nomsUnits = UnitGenerator::generatorUnit();

                $k = 0;
                foreach ($units as $unit) {
                    $path = "generator" . $nomsUnits[$k];
                    UnitGenerator::$path($isle, $manager, $unit);
                    $k++;
                }

                // Puis les machines
                $repoMachine = $this->getDoctrine()->getRepository(Machine::class);
                $machines = $repoMachine->findAll();
                $nomsMachines = MachineGenerator::generatorMachine();

                $l = 0;
                foreach ($machines as $machine) {
                    $path = "generator" . $nomsMachines[$l];
                    MachineGenerator::$path($isle, $manager, $machine);
                    $l++;
                }

                // Puis les défense
                $repoDefense = $this->getDoctrine()->getRepository(Defense::class);
                $defenses = $repoDefense->findAll();
                $nomsDefenses = DefenseGenerator::generatorDefense();

                $m = 0;
                foreach ($defenses as $defense) {
                    $path = "generator" . $nomsDefenses[$m];
                    DefenseGenerator::$path($isle, $manager, $defense);
                    $m++;
                }
                $user->setNbUnreadMessage(1);

                $manager->persist($user);
                $manager->persist($isle);
                $manager->flush();

                MessageGenerator::generatorMessageInscription($admin, $user, $manager);

                    $this->addFlash('success',"Votre inscription s'est bien dérouler, vous pouvez a présent vous connecter.");
                    return $this->redirectToRoute('home');
            }

            $this->addFlash('success',"Un problême a eu lieu lors de l'inscription, veuillez rééssayer.<br/> Pour rapelle le mot de passe doit comporté au moin 8 caractère et l'adresse mail doit être valide, <br/> n'oubliez pas de validé le captcha . Merci!");
            return $this->redirectToRoute('home');

        }
        return $this->render('home.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(){

        return $this->render('home.html.twig');
    }

    /**
     * @Route("/user/logout", name="security_logout")
     */
    public function logout(){
    }

    /**
     * @Route("/user/changePassword", name="security_changePassword")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $request->request->get('change_password')['oldPassword'];

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {

                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('game_account');
            }
            else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render("security/change_password.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/user/lastLoginTimestampForSetSession", name="security_lastLoginTimestampForSetSession")
     */
    public function LastLoginTimestampForSetSession(ObjectManager $manager, Request $request){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $isle = $em->getRepository(Isle::class)->find($user->getMainIsle());
        $user->setLastLoginTimestamp(time());
        $user->setStatus("Online");
        $manager->persist($user);
        $manager->flush();

        $session = $request->getSession();

        $session->set('wood', $isle->getWoodStock());
        $session->set('stone', $isle->getStoneStock());
        $session->set('metal', $isle->getMetalStock());
        $session->set('oil', $isle->getOilStock());
        $woodProd = $isle->getWoodProd();
        $stoneProd = $isle->getStoneProd();
        $metalProd = $isle->getMetalProd();
        $oilProd = $isle->getOilProd();

        if($user->getLastLogoutTimestamp() === null){
            $session->set('wood', $isle->getWoodStock());
            $session->set('stone', $isle->getStoneStock());
            $session->set('metal', $isle->getMetalStock());
            $session->set('oil', $isle->getOilStock());
        }

        else {
            $timestampDiff = $user->getLastLoginTimestamp() - $user->getLastLogoutTimestamp();
            $timestampDiffHours = ($timestampDiff / 60) / 60;

            if ($timestampDiffHours < 1) {
                if((($woodProd / 60) / 60) < 1){
                    $woodProd = 1;
                }
                if((($stoneProd / 60) / 60) < 1){
                    $stoneProd = 1;
                }
                if((($metalProd / 60) / 60) < 1 && $metalProd !== 0){
                    $metalProd = 1;
                }
                if((($oilProd / 60) / 60) < 1 && $oilProd !== 0){
                    $oilProd = 1;
                }
                //dd([$timestampDiffHours, $timestampDiff, $user->getLastLoginTimestamp(),$user->getLastLogoutTimestamp()]);
                $diffWood = $woodProd * $timestampDiff;
                $diffStone = $stoneProd * $timestampDiff;
                $diffMetal = $metalProd * $timestampDiff;
                $diffOil = $oilProd * $timestampDiff;
                //dd([$diffWood, $diffStone, $diffMetal, $diffOil]);
                $wood = $isle->getWoodStock() + ceil($diffWood);
                $stone = $isle->getStoneStock() + ceil($diffStone);
                $metal = $isle->getMetalStock() + ceil($diffMetal);
                $oil = $isle->getOilStock() + ceil($diffOil);
                $session->set('wood', $wood);
                $session->set('stone', $stone);
                $session->set('metal', $metal);
                $session->set('oil', $oil);
                //dd([$diffWood, $diffStone, $diffMetal, $diffOil, $wood, $stone, $metal, $oil]);
            }

            if ($timestampDiffHours > 1) {
                $wood = round($isle->getWoodStock() + ($isle->getWoodProd() * $timestampDiffHours));
                $stone = round($isle->getStoneStock() + ($isle->getStoneProd() * $timestampDiffHours));
                $metal = round($isle->getMetalStock() + ($isle->getMetalProd() * $timestampDiffHours));
                $oil = round($isle->getOilStock() + ($isle->getOilProd() * $timestampDiffHours));
                $session->set('wood', $wood);
                $session->set('stone', $stone);
                $session->set('metal', $metal);
                $session->set('oil', $oil);

            } elseif ($timestampDiffHours === 1) {
                $wood = $isle->getWoodStock() + $isle->getWoodProd();
                $stone = $isle->getStoneStock() + $isle->getStoneProd();
                $metal = $isle->getMetalStock() + $isle->getMetalProd();
                $oil = $isle->getOilStock() + $isle->getOilProd();
                $session->set('wood', $wood);
                $session->set('stone', $stone);
                $session->set('metal', $metal);
                $session->set('oil', $oil);
            } elseif ($timestampDiffHours <= 0 || $timestampDiffHours === null) {
                $wood = $isle->getWoodStock();
                $stone = $isle->getStoneStock();
                $metal = $isle->getMetalStock();
                $oil = $isle->getOilStock();
                $session->set('wood', $wood);
                $session->set('stone', $stone);
                $session->set('metal', $metal);
                $session->set('oil', $oil);
            }
        }
        return $this->redirectToRoute('game_general_view');
    }

    /**
     * @Route("/user/status", name="security_status")
     * @param Request $request
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function changeStatusAndLogout(Request $request, ObjectManager $manager): RedirectResponse
    {
        $user = $this->getUser();
        $user->setStatus('Offline');
        $idisle = $user->getMainIsle()->getId();
        $isle = $manager->getRepository(Isle::class)->find($idisle);
        $session = $request->getSession();
       /* if ($session->has('speedMission')){
            $restTimeMission = $session->get('speedMission');
            dd($restTimeMission);
        }*/
        $isle->setWoodStock(str_replace(' ', '',$session->get('wood')));
        $isle->setStoneStock(str_replace(' ', '',$session->get('stone')));
        $isle->setMetalStock(str_replace(' ', '',$session->get('metal')));
        $isle->setMetalStock(str_replace(' ', '',$session->get('oil')));

        $user->setLastLogoutTimestamp(time());
        $manager->persist($isle);
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('security_logout');
    }

    /**
     * @Route("/security/forgottenMail", name="forgotten_mail", methods="GET|POST")
     */
    public function forgottenMail(){
        return $this->render('security/forgotten_mail.html.twig');
    }

    /**
     * @Route("/security/forgottenPassword", name="forgotten_password", methods="GET|POST")
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $mail = $form->get('email')->getData();


            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['email' => $mail]);

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu, recommence !');
                return $this->redirectToRoute('forgotten_password');
            }

            /* Création du token à l'aide du TokenGeneratorInterface fournie nativement par Symfony */
            $token = $tokenGenerator->generateToken();

            /* On insère le token crée à notre utilisateur */
            $user->setResetToken($token);
            $em->persist($user);
            $em->flush();

            /* On crée une url avec notre token */
            $url = $this->generateUrl('reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            /* Envoi de mail à l'aide de swift mailer */
            $message = (new \Swift_Message('Oubli de mot de passe - Réinitialisation'))
                ->setFrom("ageofterritory@gmail.com")
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'security/MailPassword.html.twig',
                        [
                            'user'=>$user,
                            'url'=>$url
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Mail envoyé, vérifier votre boîte email!');

            return $this->redirectToRoute('home');
        }

        return $this->render('security/forgotten_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("resetPassword/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);


        //Reset avec le mail envoyé
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(User::class)->findOneByResetToken($token);

            if ($user === null) {
                $this->addFlash('danger', 'Mot de passe non reconnu');
                return $this->redirectToRoute('home');
            }

            $password = $form->get('password')->getData();


            /* On remet notre Token de reinisialisation de mot de passe sur nule */
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour !');

            return $this->redirectToRoute('security_login');
        }
        else {
            return $this->render('security/resetPassword.html.twig', ['token' => $token,'form' => $form->createView(),]
            );
        }

    }

}
