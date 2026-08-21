<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tasks')]
class TaskController extends AbstractController
{
    #[Route('', name: 'task_index', methods: ['GET'])]
    public function index(Request $request, TaskRepository $repository): Response
    {
        $status = $request->query->get('status');
        $priority = $request->query->get('priority');

        return $this->render('task/index.html.twig', [
            'tasks' => $repository->findFiltered($status, $priority),
            'statuses' => Task::STATUSES,
            'priorities' => Task::PRIORITIES,
            'current_status' => $status,
            'current_priority' => $priority,
        ]);
    }

    #[Route('/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success', 'La tâche a été ajoutée.');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/form.html.twig', ['form' => $form, 'page_title' => 'Nouvelle tâche']);
    }

    #[Route('/{id}', name: 'task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', ['task' => $task]);
    }

    #[Route('/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->touch();
            $entityManager->flush();
            $this->addFlash('success', 'La tâche a été modifiée.');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/form.html.twig', ['form' => $form, 'page_title' => 'Modifier la tâche']);
    }

    #[Route('/{id}/delete', name: 'task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success', 'La tâche a été supprimée.');
        }

        return $this->redirectToRoute('task_index');
    }

    #[Route('/{id}/toggle-status', name: 'task_toggle_status', methods: ['POST'])]
    public function toggleStatus(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('toggle-status'.$task->getId(), $request->request->get('_token'))) {
            $task->setStatus($task->getStatus() === 'Terminée' ? 'À faire' : 'Terminée');
            $task->touch();
            $entityManager->flush();
            $this->addFlash('success', $task->getStatus() === 'Terminée' ? 'La tâche est terminée.' : 'La tâche est rouverte.');
        }

        return $this->redirectToRoute('task_index');
    }
}