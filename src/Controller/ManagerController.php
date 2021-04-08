<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Task;
use App\Repository\ProjetRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/admin/list", name="list_projet")
     */
    public function list(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();
        return $this->render('projet/list.html.twig', [
            'projets' => $projets
        ]);
    }

    /**
     * @Route("/add_post", name="post_add")
     * @param Request $request
     */
    public function addPost(Request $request, 
                            EntityManagerInterface $entityManager)
    {
        if ($request->getMethod() == 'POST') {
            $project = new projet();
            $project->setName($request->request->get('name'));
            $project->setStartedAt(new \DateTime);
            $project->setEndedAt(new \DateTime);
            $project->setStatus("nouveau");
            // if($project->getStatut() != "Terminé") {
            //     $project->setStatut($request->request->get('statut'));
            // }
            
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('list_projet');
        }

        return $this->render('projet/add.html.twig');
    }

    /**
     * @Route("/projet/{id}", name="projet_show")
     */
    public function showPost($id, ProjetRepository $projetRepository)
    {
        $projet = $projetRepository->find($id);
        return $this->render('projet/show.html.twig', ['projet' => $projet]);
    }

    // /**
    //  * @Route("/projet/{id}", name="project_show")
    //  */
    // public function Modif($id, Request $request, EntityManagerInterface $entityManager, ProjetRepository $projectRepository, TaskRepository $taskRepository)
    // {
    //     $project = $projectRepository->find($id);
    //     $task = $taskRepository->getTasksById($id);
    //     if ($request->getMethod() === 'POST') {

    //         if($project->getStatus() != "Terminé") {
    //             $project->setStatus($request->request->get('status'));

    //             $entityManager->persist($project);
    //             $entityManager->flush();
    //         }

    //         return $this->redirect('/');
    //     }
        
    // }


    // /**
    //  * @Route("/add_task", name="add_task")
    //  * @param Request $request
    //  */
    // public function addTask(Request $request, 
    //                         EntityManagerInterface $entityManager, 
    //                         TaskRepository $taskRepository)
    // {
    //     if ($request->getMethod() == 'POST') {
    //         $projetId = 1; 
    //         $task = $taskRepository->find($projetId);

    //         $title = $request->request->get('title');
    //         $description = $request->request->get('description');

    //         $task = new Task();
            
    //         $task->setTitle($title);
    //         $task->setDescription($description);

    //         $entityManager->persist($task);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('list_projet');
    //     }

    //     return $this->render('task/add.html.twig');
    // }

    /**
     * @Route("/task/{id}", name="add_task")
     */
    public function addTask2($id, Request $request, EntityManagerInterface $entityManager)
    {
        if ($request->getMethod() === 'POST') {
            $task = new Task();
            $task->setTitle($request->request->get('name'));
            $task->setProjetId($id);
            $task->setDescription($request->request->get('description'));

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirect('/');
        }

        return $this->render('task/add.html.twig');
    }




}