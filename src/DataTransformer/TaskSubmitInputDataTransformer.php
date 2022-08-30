<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\AppUser;
use App\Entity\CodeLanguage;
use App\Entity\SubmitType;
use App\Entity\Task;
use App\Entity\TaskSubmit;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class TaskSubmitInputDataTransformer implements DataTransformerInterface
{
    private $doctrine;
    private $tokenStorage;

    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $taskSubmit = new TaskSubmit();

        $user = $this->doctrine->getRepository(AppUser::class)->find($this->tokenStorage->getToken()->getUser());
        $task = $this->doctrine->getRepository(Task::class)->find($data->taskId);

        $lang = $this->doctrine->getRepository(CodeLanguage::class)->findOneBy(["shortName" => $data->language]);
        $type = $this->doctrine->getRepository(SubmitType::class)->findOneBy(["name"=> $data->type]);

        $taskSubmit->setFileContent($data->code)
            ->setTask($task)
            ->setUser($user)
            ->setCodeLanguage($lang)
            ->setSubmitType($type);

        return $taskSubmit;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof TaskSubmit) {
            return false;
        }

        return TaskSubmit::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
