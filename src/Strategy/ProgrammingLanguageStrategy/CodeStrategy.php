<?php

namespace App\Strategy\ProgrammingLanguageStrategy;

use App\Entity\TaskSubmit;
use App\Strategy\EvaluationStrategyInterface;

final class CodeStrategy implements EvaluationStrategyInterface
{
    private const PRIORITY = 10;

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    public function isEvaluable(array &$params, TaskSubmit $taskSubmit): bool
    {
        // some logic that checks if submit should be evaluated
        return true;
    }

    public function evaluate(TaskSubmit $tasksubmit) : void
    {
        $tasksubmit->setEvaluatedBy($tasksubmit->getEvaluatedBy()." ". get_class($this));

        $score = min(rand(0, 100)/100.0+0.2, 1);

        $tasksubmit->setScore($score);
        $now = new \DateTime("now");
        $diff = $tasksubmit->getUploadDate()->diff($now);
        $tasksubmit->setEvaluationTime(($diff->format('%s.%f')));
        $tasksubmit->setEvaluationDate(new \DateTime("now"));
        $tasksubmit->setEvaluated(true);

    }

}
