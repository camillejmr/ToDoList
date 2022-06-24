<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Entity\Task;
use App\Form\ListeType;
use App\Form\TaskType;
use App\Repository\ListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
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
    public function listes(ListeRepository $listeRepository): Response
    {
        $listes = $listeRepository->findBest();
//        $listes = $listeRepository->findBy([],['finished'=>'DESC']);
        return $this->render('liste/listes.html.twig', ["listes" => $listes
        ]);
    }
//
//    /**
//     * @Route("/detailsliste/{id}", name="details")
//     */
//
//    public function detailsList(Request $request, int $id, ListeRepository $listeRepository, EntityManagerInterface $entityManager): Response
//    {
//        dump($id);
//
//        $liste = $listeRepository->find($id);
//        $task = new Task;
//        $taskForm = $this->createForm(TaskType::class, $task);
//        $taskForm->handleRequest($request);
//
//        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
//            $entityManager->persist($task);
//            $entityManager->flush();
//            $this->addFlash('success', 'La tâche a bien été ajoutée, Merci !');
//
//            return $this->redirectToRoute('listes_details', ['id' => $liste->getId()]);
//        }
//        return $this->render('liste/details.html.twig', ["liste" => $liste, "taskForm" => $taskForm->createView()]);
//
//    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $liste = new Liste();
        $liste->setDateCreation(new \DateTime());
        $liste->setFinished('0');
        $liste->setDateLastModification(new \DateTime());
        $listeForm = $this->createForm(ListeType::class, $liste);
        $listeForm->handleRequest($request);

        if ($listeForm->isSubmitted() && $listeForm->isValid()) {
            $entityManager->persist($liste);
            $entityManager->flush();
            $this->addFlash('success', 'La liste a bien été ajoutée, Merci !');

            return $this->redirectToRoute('listes_details', ['id' => $liste->getId()]);
        }

        return $this->render('liste/create.html.twig', ['listeForm' => $listeForm->createView()
        ]);
    }
}
