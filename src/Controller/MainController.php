<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "main_home", methods: ["GET"])]
    public function home() : Response {
        return $this->render('home/index.html.twig');
    }

    #[Route("/about-us", name: "main_about_us", methods: ["GET"])]
    public function aboutUs() : Response {
        return $this->render('home/about-us.html.twig');
    }

}

