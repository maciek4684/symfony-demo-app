<?php


namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\TaskSubmit;
use App\Exception\ResourceNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class APIResourceManageSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['checkResourceExists', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function checkResourceExists(ViewEvent $event): void
    {
        $taskSubmit = $event->getControllerResult();

        if (!$taskSubmit instanceof TaskSubmit) {
            return;
        }

        if ($taskSubmit->getTask() == null) {
            throw new ResourceNotFoundException('Could not store task submit. The task does not exist.');
        }
    }
}
