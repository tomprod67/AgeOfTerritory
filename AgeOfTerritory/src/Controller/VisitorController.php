<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    /**
     * @Route("/thomas", name="red")
     */
    public function red()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        if ($this->getUser() === null) {
                return $this->render('home.html.twig');
        }
        return $this->redirectToRoute('game');
    }
}
