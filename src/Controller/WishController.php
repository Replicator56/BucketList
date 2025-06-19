<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/wishes", name: "wish_")]
class WishController extends AbstractController
{
    #[Route("", name: "all", methods: ["GET"])]
    public function all(WishRepository $wishRepository) : Response {
        $wishes = $wishRepository->findBy(["isPublished" => true], ["dateCreated" => "DESC"]);

        return $this->render('wish/list.html.twig', [ 'wishes' => $wishes ]);
    }

    #[Route("/{id}", name: "details", methods: ["GET"])]
    public function details(int $id, WishRepository $wishRepository) : Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Souhait non trouvé");
        }

        return $this->render('wish/detail.html.twig', [ 'wish' => $wish ]);
    }
}
