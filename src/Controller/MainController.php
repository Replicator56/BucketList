<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route("/",name: "Home",methods: ["GET"])]
    public function home() : Response{
        return $this->render('index.html.twig');
    }

}

