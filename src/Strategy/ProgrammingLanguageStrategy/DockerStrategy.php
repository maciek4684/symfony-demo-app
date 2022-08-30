<?php

namespace App\Strategy\ProgrammingLanguageStrategy;


use App\Entity\TaskSubmit;
use App\Strategy\EvaluationStrategyInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final class DockerStrategy implements EvaluationStrategyInterface
{
    private const PRIORITY = 50;
    private KernelInterface $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    public function isEvaluable(array &$params, TaskSubmit $taskSubmit): bool
    {
        // some logic to check if task has docker tests defined
        return true;
    }

    public function evaluate(TaskSubmit $tasksubmit) : void
    {
        // add logic for execution of docker configuration

        $tasksubmit->setEvaluatedBy($tasksubmit->getEvaluatedBy()." ". get_class($this));
        $now = new \DateTime("now");
        $diff = $tasksubmit->getUploadDate()->diff($now);
        $tasksubmit->setEvaluationTime(($diff->format('%s.%f')));
        $tasksubmit->setEvaluationDate(new \DateTime("now"));
        $tasksubmit->setEvaluated(true);

    }

}
