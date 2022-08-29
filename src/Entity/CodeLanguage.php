<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CodeLanguageRepository")
 */

#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => 'list']
        ],
        'post' =>[
            'normalization_context' => ['groups' => 'list']
        ]
    ],
    itemOperations: [
        'get' =>
            [
                'normalization_context' => ['groups' => 'item']
            ]
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class CodeLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"list", "item"})
     */
    private string $shortName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list", "item"})
     */
    private string $fullName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Task", mappedBy="codeLanguages")
     * @Groups({"item"})
     */
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->addSubmitType($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            $task->removeSubmitType($this);
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getFullName();
    }


}
