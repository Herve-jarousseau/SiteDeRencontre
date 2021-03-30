<?php


namespace App\Controller;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @Route("/", name="main_home")
     */
    public function home(): Response {
        return $this->render('main/home.html.twig', []);
    }

    /**
     * @Route("/legal", name="main_legalNotices")
     */
    public function legalNotices(): Response {
        return $this->render('main/legalNotices.html.twig', []);
    }

    /**
     * @Route("/terms", name="main_terms")
     */
    public function termsOfService(): Response {
        return $this->render('main/termsOfService.html.twig', []);
    }
}