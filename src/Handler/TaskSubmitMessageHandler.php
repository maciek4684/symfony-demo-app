<?php

namespace App\Handler;

use App\Message\TaskSubmitMessage;
use App\Repository\TaskSubmitRepository;
use App\Strategy\TaskEvaluator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class TaskSubmitMessageHandler implements MessageHandlerInterface
{
    private TaskSubmitRepository $taskSubmitRepository;
    private TaskEvaluator $evaluator;
    private EntityManagerInterface $em;

    public function __construct(TaskSubmitRepository $taskSubmitRepository, TaskEvaluator $evaluator, EntityManagerInterface $em)
    {
        $this->taskSubmitRepository = $taskSubmitRepository;
        $this->evaluator = $evaluator;
        $this->em = $em;
    }

    public function __invoke(TaskSubmitMessage $taskSubmit)
    {
        // read task submit id, retrieve data from database and send to evaluation
        $submit = $this->taskSubmitRepository->find($taskSubmit->getTaskSubmitId());

        $evaluatorParams = array(
            "some" => "",
            "additional" => "" ,
            "configuration" => "" ,
            "params" => ""
        );

        $this->evaluator->handleSubmitEvaluation($evaluatorParams, $submit);

        $this->em->persist($submit);
        $this->em->flush();
    }

}
