<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\ListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("details/{id}", name="details")
     */
    public function detailsList(int $id, ListeRepository $listeRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $liste = $listeRepository->findOneById($id);


        $task = new Task();
        $task->setIdListe($liste);
        $taskForm = $this->createForm(TaskType::class, $task);
        $taskForm->handleRequest($request);

        if ($taskForm->isSubmitted() && $taskForm->isValid()) {
            $task->setDone(false);
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success', 'La tâche ' . $task->getTask() . ' a bien été ajoutée à votre liste ' . $liste->getName() . '!');
            return $this->redirectToRoute('details', ['id' => $liste->getId()]);
        }

        return $this->render('task/details.html.twig', ['taskForm' => $taskForm->createView(), 'liste' => $liste,

        ]);
    }

    /**
     * @Route("updateTask/{id}", name="updateTask")
     */
    public function updateTask(ListeRepository $listeRepository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $liste = $listeRepository->findOneById($id);
        $taskForm = $this->createForm(TaskType::class, $task);
        $taskForm->handleRequest($request);
        foreach ($liste->getListTasks() as $task) {

            if (array_key_exists((string)$task->getId(), $request->request->all())) {
                $task->setDone(true);
                $entityManager->persist($task);
                $entityManager->flush();
            } else {
                $task->setDone(false);
                $entityManager->persist($task);
                $entityManager->flush();
            }
        }
        $liste->setDateLastModification(new \DateTime());

        $entityManager->persist($liste);
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour des tâches effectuées.');

        return $this->redirectToRoute('details', ['id' => $liste->getId()]);
    }
}
