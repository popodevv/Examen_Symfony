<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/projects", name="api_projects", methods={"GET"})
     */
    public function projectList(ProjetRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->json($projects, 200, [], [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractObjectNormalizer::ATTRIBUTES => [
                'id',
                'name',
                'status'
            ]
        ]);
    }

    /**
     * @Route("/api/task/{id}", name="api_task", methods={"GET"})
     *
     * @param integer $id
     * @param ProjetRepository $projetRepository
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function taskByProject(int $id, ProjetRepository $projectRepository, TaskRepository $taskRepository): Response
    {
        $project = $projectRepository->findOneBy(['id' => $id]);
        $tasks = $taskRepository->findBy(['projectId' => $project]);

        
        return $this->json($tasks, 200, [], [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractObjectNormalizer::ATTRIBUTES => [
                'id',
                'title',
                'description'
            ]
        ]);
    }
}