<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubmitTypeRepository")
 */
class SubmitType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaskSubmit", mappedBy="submitType")
     */
    private $taskSubmits;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Task", mappedBy="submitTypes")
     */
    private $tasks;

    public function __construct()
    {
        $this->taskSubmits = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|TaskSubmit[]
     */
    public function getTaskSubmits(): Collection
    {
        return $this->taskSubmits;
    }

    public function addTaskSubmit(TaskSubmit $taskSubmit): self
    {
        if (!$this->taskSubmits->contains($taskSubmit)) {
            $this->taskSubmits[] = $taskSubmit;
            $taskSubmit->setSubmitType($this);
        }

        return $this;
    }

    public function removeTaskSubmit(TaskSubmit $taskSubmit): self
    {
        if ($this->taskSubmits->contains($taskSubmit)) {
            $this->taskSubmits->removeElement($taskSubmit);
            // set the owning side to null (unless already changed)
            if ($taskSubmit->getSubmitType() === $this) {
                $taskSubmit->setSubmitType(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->getName();
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
}
