<?php

namespace App\Dto;

class TaskSubmitOutput
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var bool
     */
    public ?bool $evaluated;

    /**
     * @var float
     */
    public ?float $score;

    /**
     * @var string`
     */
    public string $codeLanguage;

    /**
     * @var string
     */
    public string $uploadDate;

    /**
     * @var array
     */
    public array $testList;

    /**
     * @var array
     */
    public array $errorList;

}
