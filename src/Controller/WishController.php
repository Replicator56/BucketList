<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WishController extends AbstractController
{
    #[Route("/wishes", name: "wishes", methods: ["GET"])]
    public function allWishes() : Response {
        return $this->render('wish/list.html.twig');
    }

    #[Route("/wishes/{id}", name: "wishes_details", methods: ["GET"])]
    public function wishesDetail(int $id) : Response
    {
        return $this->render('wish/detail.html.twig', [
            'id' => $id,
        ]);
    }


}
