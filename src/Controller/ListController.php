<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/listes", name="listes_")
 */
class ListController extends AbstractController
{
    /**
     * @Route("", name="listes")
     */
    public function listes(): Response
    {
        if ($user = $this->getUser()) {
            $listes = $user->getListes();
            return $this->render('liste/listes.html.twig', ["listes" => $listes
            ]);

        }

        $this->addFlash('success', 'Vous devez vous connecter pour accéder à vos listes.');
        return $this->render('liste/listes.html.twig', []);

    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            $liste = new Liste();
            $listeForm = $this->createForm(ListeType::class, $liste);
            $listeForm->handleRequest($request);

            if ($listeForm->isSubmitted() && $listeForm->isValid()) {
                $liste->setDateCreation(new \DateTime());
                $liste->setFinished('0');
                $liste->setDateLastModification(new \DateTime());
                $user = $this->getUser();
                $liste->setIdUser($user);
                $entityManager->persist($liste);
                $entityManager->flush();
                $this->addFlash('success', 'La liste a bien été ajoutée, Merci !');

                return $this->redirectToRoute('details', ['id' => $liste->getId()]);
            }

            return $this->render('liste/create.html.twig', ['listeForm' => $listeForm->createView()
            ]);
        }
        $this->addFlash('success', 'Veuillez vous connecter ou créer un compte pour créer une liste!');
        return $this->render('liste/create.html.twig', [
        ]);
    }
}
