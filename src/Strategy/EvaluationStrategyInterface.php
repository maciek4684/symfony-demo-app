<?php

namespace App\Strategy;

use App\Entity\TaskSubmit;

interface EvaluationStrategyInterface
{
    public const SERVICE_TAG = 'submit_strategy';

    // enforce unique values for strategies
    // if two strategies share the same priority
    // one will overwrite the previous
    public function getPriority(): int;

    public function isEvaluable(array &$params, TaskSubmit $taskSubmit): bool;
    public function evaluate(TaskSubmit $taskSubmit): void;
}
