<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskSubmitRepository")
 * @ORM\Table(indexes={
 *     @ORM\Index(name="dt_search_idx", columns={"upload_date"})
 * })
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
class TaskSubmit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list", "item"})
     */
    private $fileContent;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
     * @Groups({"list", "item"})
     */
    private $score;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"list", "item"})
     */
    private $uploadDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"list", "item"})
     */
    private $evaluationDate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private $errorCount;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private $warningCount;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "item"})
     */
    private $testCount;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"item"})
     */
    private $errorList=[];

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"item"})
     */
    private $warningList=[];

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"item"})
     */
    private $testList = [];

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
     * @Groups({"item"})
     */
    private $evaluationTime;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $testServerId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AppUser", inversedBy="taskSubmits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"item"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="taskSubmits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"item"})
     */
    private $task;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"list", "item"})
     */
    private $evaluated;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $evaluatedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubmitType", inversedBy="taskSubmits")
     * @ORM\JoinColumn(nullable=true)
     */
    private $submitType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CodeLanguage")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"list", "item"})
     */
    private $codeLanguage;


    public function __construct()
    {}

    /**
     * @Groups({"view_exam_results"})
    */
    public function getEmail()
    {
        return $this->user->getEmail();
    }

    public function getId(): ?int
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

    public function getTestListAsString()
    {
        return json_encode($this->testList, JSON_PRETTY_PRINT);
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

    public function getTestData(): string
    {
        return $this->getTask()->getTestData();
    }

    public function addToTestList($item)
    {
        $list = json_decode($this->testList);

        array_push($list,
            $item);
        $this->setTestList( json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function addToErrorList($item)
    {
        array_push($this->errorList,
            $item);
        $this->setErrorList($this->errorList);
    }

    public function addToWarningList($item)
    {
        $list = $this->getWarningList();

        array_push($list,
            $item);
        $this->setWarningList($list);
    }

    public function initialize(string $content, Task $task, AppUser $user)
    {
        $this->uploadDate = new \DateTime("now");
        $this->testCount = 0;
        $this->errorCount = 0;
        $this->warningCount = 0;
        $this->submitType = $task->getSubmitTypes()[0];
        $this->codeLanguage=$task->getCodeLanguages()[0];

        $this->setScore(null);

        $this->errorList = [];
        $this->warningList = [];
        $this->testList = [];
        $this->setEvaluatedBy("[]");
        $this->setFilecontent($content);

        $this->setTask($task);
        $this->setUser($user);

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
    public function addToEvaluatedBy($item)
    {
        $list = json_decode($this->evaluatedBy);

        if (is_null($list))
            $list = [];

        array_push($list,
            $item);
        $this->setEvaluatedBy( json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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

    public function __toString()
    {
        return (string)$this->id;
    }

}
