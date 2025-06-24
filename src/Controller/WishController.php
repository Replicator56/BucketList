<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Service\CensuratorService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route("/{id}", name: "details", requirements: ['id' => '\d+'], methods: ["GET"])]
    public function details(int $id, WishRepository $wishRepository) : Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Souhait non trouvé");
        }

        return $this->render('wish/detail.html.twig', [ 'wish' => $wish ]);
    }

    #[Route("/create", name: "create")]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request,
        CensuratorService $censuratorService
    ) : Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException("User is not logged in");
        }

        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            try {
                $originalTitle = $wish->getTitle();
                $purifiedTitle = $censuratorService->purify($originalTitle);
                $wish->setTitle($purifiedTitle);

                $originalDescription = $wish->getDescription();
                $purifiedDescription = $censuratorService->purify($originalDescription);
                $wish->setDescription($purifiedDescription);

                $wish->setDateCreated(new \DateTime());
                $wish->setAuthor($user);
                $entityManager->persist($wish);
                $entityManager->flush();
                $this->addFlash('success', "Idea successfully added!");
                return $this->redirectToRoute('wish_details', ["id" => $wish->getId()]);
            } catch (Exception $exception) {
                $this->addFlash('warning', $exception->getMessage());
            }
        }



        return $this->render('wish/create.html.twig', [
            'wishForm' => $wishForm
        ]);
    }

    #[Route("/{id}/update", name: "update", requirements: ["id" => "\d+"])]
    public function update(
        int $id,
        WishRepository $wishRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ) : Response {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Le souhait n'existe pas");
        }

        $isAuthor = $this->getUser()->getUserIdentifier() === $wish->getAuthor()->getUserIdentifier();

        if (!$isAuthor) {
            throw $this->createAccessDeniedException("User is not the author");
        }

        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            try {
                $wish->setDateUpdated(new \DateTime());
                $entityManager->persist($wish);
                $entityManager->flush();
                $this->addFlash('success', "Idea successfully updated!");
                return $this->redirectToRoute('wish_details', ["id" => $wish->getId()]);
            } catch (Exception $exception) {
                $this->addFlash('warning', $exception->getMessage());
            }
        }

        return $this->render("wish/update.html.twig", [
            'wishForm' => $wishForm
        ]);
    }

    #[Route("/{id}/delete", name: "delete", requirements: ["id" => "\d+"])]
    public function delete(
        int $id,
        EntityManagerInterface $entityManager,
        WishRepository $wishRepository
    ) : Response {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Le souhait n'existe pas");
        }

        $isAuthor = $this->getUser()->getUserIdentifier() === $wish->getAuthor()->getUserIdentifier();
        $isAdmin = $this->isGranted("ROLE_ADMIN");

        if (!($isAuthor or $isAdmin)) {
            throw $this->createAccessDeniedException("Acces denied");
        }

        try {
            $entityManager->remove($wish);
            $entityManager->flush();

            return $this->redirectToRoute('wish_all');
        } catch (Exception $exception) {
            $this->addFlash('warning', $exception->getMessage());
        }

        return $this->redirectToRoute('wish_details', ["id" => $wish->getId()]);
    }

}
