<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TaskSubmit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class TaskSubmitController extends AbstractController
{
    /**
     * @Route("/task/{taskSlug}", name="submit_solution", methods={"GET"} )
     */
    public function submitSolution(Request $request, ManagerRegistry $doctrine, string $taskSlug): Response
    {
        $task = $doctrine
            ->getRepository(Task::class)
            ->findOneBy(['slug' => $taskSlug]);

        if ($task == null)
        {
            $this->addFlash('warning','submit.task_not_found');
            return $this->redirectToRoute('default');
        }

        if (!$this->isGranted('view', $task))
        {
            $this->addFlash('success','submit.task_not_found');
            return $this->redirectToRoute('default');
        }

        $latestSubmits = $doctrine
            ->getRepository(TaskSubmit::class)
            ->findBy(["user" => $this->getUser(), "task" => $task], ["id" => "DESC"], 3);

        return $this->render('task/submit-solution.html.twig',
            array(
            'submits'=>$latestSubmits,
            'task'=> $task
        ));
    }
}
