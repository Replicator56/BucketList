<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/wishes", name: "wish_")]
class WishController extends AbstractController
{
    #[Route("", name: "all", methods: ["GET"])]
    public function all() : Response {
        return $this->render('wish/list.html.twig');
    }

    #[Route("/{id}", name: "details", methods: ["GET"])]
    public function details(int $id) : Response
    {
        return $this->render('wish/detail.html.twig', [
            'id' => $id,
        ]);
    }
}
