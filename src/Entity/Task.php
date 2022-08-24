<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
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
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"list", "item"})
     */
    private $title;

    /**
     * @Gedmo\Mapping\Annotation\Slug(fields={"title"})
     * @ORM\Column(type="string", length=200, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length (min = 5 )
     * @Groups({"list", "item"})
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaskSubmit",
     *     mappedBy="task",
     *     cascade={"remove"},
     *     fetch="LAZY")
     * @Groups({"item"})
     */
    private $taskSubmits;

    /**
     * @return mixed
     */
    public function getTaskSubmits()
    {
        return $this->taskSubmits;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CodeLanguage", inversedBy="tasks")
     */
    private $codeLanguages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubmitType", inversedBy="tasks")
     */
    private $submitTypes;


    public function __construct()
    {
        $this->codeLanguages = new ArrayCollection();
        $this->submitTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getTitle();
    }

    /**
     * @return Collection|CodeLanguage[]
     */
    public function getCodeLanguages(): Collection
    {
        return $this->codeLanguages;
    }

    public function addCodeLanguage(CodeLanguage $codeLanguage): self
    {
        if (!$this->codeLanguages->contains($codeLanguage)) {
            $this->codeLanguages[] = $codeLanguage;
        }

        return $this;
    }

    public function removeCodeLanguage(CodeLanguage $codeLanguage): self
    {
        if ($this->codeLanguages->contains($codeLanguage)) {
            $this->codeLanguages->removeElement($codeLanguage);
        }

        return $this;
    }

    /**
     * @return Collection|SubmitType[]
     */
    public function getSubmitTypes(): Collection
    {
        return $this->submitTypes;
    }

    public function addSubmitType(SubmitType $submitType): self
    {
        if (!$this->submitTypes->contains($submitType)) {
            $this->submitTypes[] = $submitType;
        }

        return $this;
    }

    public function removeSubmitType(SubmitType $submitType): self
    {
        if ($this->submitTypes->contains($submitType)) {
            $this->submitTypes->removeElement($submitType);
        }

        return $this;
    }

}
