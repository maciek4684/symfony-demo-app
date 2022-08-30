<?php


namespace App\Strategy\ProgrammingLanguageStrategy;

use App\Entity\TaskSubmit;
use App\Strategy\EvaluationStrategyInterface;

final class  PenaltyStatementStrategy implements EvaluationStrategyInterface
{
    private const PRIORITY = 30;

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    public function isEvaluable(array &$params, TaskSubmit $taskSubmit): bool
    {
        return true;
    }

    public function evaluate(TaskSubmit $tasksubmit) : void
    {
        $tasksubmit->setEvaluatedBy($tasksubmit->getEvaluatedBy()."\n". get_class($this));
    }

}
