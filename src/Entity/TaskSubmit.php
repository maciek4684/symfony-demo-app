<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\TaskSubmitInput;
use App\Dto\TaskSubmitOutput;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskSubmitRepository")
 * @ORM\Table(indexes={
 *     @ORM\Index(name="dt_search_idx", columns={"upload_date"})
 * })
 */

#[ApiResource(
    collectionOperations: [
        "create" => [
            "method" => "POST",
            "input" => TaskSubmitInput::class,
            "path"=> "/task_submits",
            "messenger" => true,
            "output" => TaskSubmitOutput::class,
            "status" => 201
        ],
    ],
    itemOperations: [
        "get" => [
            "output" => TaskSubmitOutput::class,
         ],
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class TaskSubmit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private int $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list", "item"})
     */
    private string $fileContent;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
     * @Groups({"list", "item"})
     */
    private ?float $score;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"list", "item"})
     */
    private \DateTime $uploadDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"list", "item"})
     */
    private \DateTime $evaluationDate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private int $errorCount;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private int $warningCount;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private int $testCount;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"item"})
     */
    private ?array $errorList=[];

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"item"})
     */
    private ?array $warningList=[];

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"item"})
     */
    private ?array $testList = [];

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
     * @Groups({"item"})
     */
    private float $evaluationTime;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $testServerId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AppUser", inversedBy="taskSubmits")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserInterface $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="taskSubmits")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Task $task;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"list", "item"})
     */
    private ?bool $evaluated;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $evaluatedBy = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubmitType", inversedBy="taskSubmits")
     * @ORM\JoinColumn(nullable=true)
     */
    private SubmitType $submitType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CodeLanguage")
     * @ORM\JoinColumn(nullable=true)
     */
    private CodeLanguage $codeLanguage;

    public function __construct()
    {
        $this->setUploadDate(new \DateTime("now"));
        $this->setErrorCount(0);
        $this->setWarningCount(0);
        $this->setTestCount(0);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFileContent(): ?string
    {
        return $this->fileContent;
    }

    public function setFileContent(?string $fileContent): self
    {
        $this->fileContent = $fileContent;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadDate;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    public function getEvaluationDate(): ?\DateTimeInterface
    {
        return $this->evaluationDate;
    }

    public function setEvaluationDate(?\DateTimeInterface $evaluationDate): self
    {
        $this->evaluationDate = $evaluationDate;

        return $this;
    }

    public function getErrorCount(): ?int
    {
        return $this->errorCount;
    }

    public function setErrorCount(int $errorCount): self
    {
        $this->errorCount = $errorCount;

        return $this;
    }

    public function getWarningCount(): ?int
    {
        return $this->warningCount;
    }

    public function setWarningCount(int $warningCount): self
    {
        $this->warningCount = $warningCount;

        return $this;
    }

    public function getTestCount(): ?int
    {
        return $this->testCount;
    }

    public function setTestCount(int $testCount): self
    {
        $this->testCount = $testCount;

        return $this;
    }

    public function getErrorList(): ?array
    {
        return $this->errorList;
    }

    public function setErrorList(?array $errorList): self
    {
        $this->errorList = $errorList;

        return $this;
    }

    public function getWarningList(): ?array
    {
        return $this->warningList;
    }

    public function setWarningList(?array $warningList): self
    {
        $this->warningList = $warningList;

        return $this;
    }


    public function getTestList(): ?array
    {
        return $this->testList;
    }

    public function setTestList(?array $testList): self
    {
        $this->testList = $testList;

        return $this;
    }

    public function getEvaluationTime(): ?float
    {
        return $this->evaluationTime;
    }

    public function setEvaluationTime(?float $evaluationTime): self
    {
        $this->evaluationTime = $evaluationTime;

        return $this;
    }

    public function getTestServerId(): ?string
    {
        return $this->testServerId;
    }

    public function setTestServerId(?string $testServerId): self
    {
        $this->testServerId = $testServerId;

        return $this;
    }

    public function getUser(): ?AppUser
    {
        return $this->user;
    }

    public function setUser(?AppUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }


    public function getEvaluated(): ?bool
    {
        return $this->evaluated;
    }

    public function setEvaluated(?bool $evaluated): self
    {
        $this->evaluated = $evaluated;

        return $this;
    }

    public function getEvaluatedBy(): ?string
    {
        return $this->evaluatedBy;
    }

    public function setEvaluatedBy(?string $evaluatedBy): self
    {
        $this->evaluatedBy = $evaluatedBy;

        return $this;
    }

    public function getSubmitType(): ?SubmitType
    {
        return $this->submitType;
    }

    public function setSubmitType(?SubmitType $submitType): self
    {
        $this->submitType = $submitType;

        return $this;
    }

    public function getCodeLanguage(): ?CodeLanguage
    {
        return $this->codeLanguage;
    }

    public function setCodeLanguage(?CodeLanguage $codeLanguage): self
    {
        $this->codeLanguage = $codeLanguage;

        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

}
