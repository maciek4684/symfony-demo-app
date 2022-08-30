<?php

namespace App\Dto;

class TaskSubmitInput
{
    /**
     * @var int
     */
    public string $taskId;

    /**
     * @var string
     */
    public string $code;

    /**
     * @var string
     */
    public string $language;

    /**
     * @var string
     */
    public string $type;

}
