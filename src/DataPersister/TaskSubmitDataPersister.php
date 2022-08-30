<?php


namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\TaskSubmit;
use App\Message\TaskSubmitMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class TaskSubmitDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $messageBus;

    public function __construct(EntityManagerInterface $entityManager, MessageBusInterface $messageBus)
    {
        $this->entityManager = $entityManager;
        $this->messageBus = $messageBus;
    }

    public function supports($data): bool
    {
        return $data instanceof TaskSubmit;
    }

    public function persist($data)
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        $message = new TaskSubmitMessage($data->getId());
        $this->messageBus->dispatch($message);
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
