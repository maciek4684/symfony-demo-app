<?php


namespace App\Message;

final class TaskSubmitMessage
{
    // store task submit id to process by messenger
    private int $taskSubmitId;

    public function __construct(int $taskSubmitId)
    {
        $this->taskSubmitId = $taskSubmitId;
    }

    public function getTaskSubmitId(): int
    {
        return $this->taskSubmitId;
    }

}
