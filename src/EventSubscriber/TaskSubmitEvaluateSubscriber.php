<?php


namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\AfterTaskSubmitEvaluatedEvent;

final class TaskSubmitEvaluateSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    // we will be notified, when the task submission is evaluated
    public function onTaskSubmitEvaluated(AfterTaskSubmitEvaluatedEvent $event)
    {
        // execute user-related algorithms, update model predictions, etc.

        // send data to log
        $this->logger->info("Task evaluated.");
    }

    public static function getSubscribedEvents()
    {
        return [
            'tester.post_evaluated' => 'onTaskSubmitEvaluated',
        ];
    }
}
