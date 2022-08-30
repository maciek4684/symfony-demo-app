<?php


namespace App\Strategy;

use App\Entity\TaskSubmit;
use App\Event\AfterTaskSubmitEvaluatedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class TaskEvaluator
{
    /**
     * @var EvaluationStrategyInterface[]
     */
    private $strategies;

    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    // used in compiler pass to update strategy array
    public function addStrategy(EvaluationStrategyInterface $strategy): void
    {
        $this->strategies[$strategy->getPriority()] = $strategy;
    }

    public function handleSubmitEvaluation(array $params, TaskSubmit $taskSubmit): void
    {
        $strategies = $this->strategies;

        // order strategies by priority
        ksort($strategies);

        /**
         * @var EvaluationStrategyInterface $strategy
         * @var EvaluationStrategyInterface[] $strategies
         */
        foreach ($strategies as $strategy)
        {
            if ($strategy->isEvaluable($params, $taskSubmit)) {
                $strategy->evaluate($taskSubmit);
            }
        }

        // create event when task evaluation finished
        $event = new AfterTaskSubmitEvaluatedEvent($taskSubmit->getTask()->getTitle());
        $this->dispatcher->dispatch($event, 'tester.post_evaluated');
    }
}
