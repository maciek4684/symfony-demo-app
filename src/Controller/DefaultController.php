<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    #[Route('/', name: 'default')]
    public function index(TaskRepository $taskRepository) : Response
    {
        $tasks = $taskRepository->findUserSubmits($this->getUser()->getId());

        return $this->render('default/default.html.twig', array(
            "tasks" => $tasks
        ));
    }

    #[Route('/api/login', name: 'api_login')]
    public function apiLogin(Request $request)
    {
        return new Response("ok", 201);
    }
}
