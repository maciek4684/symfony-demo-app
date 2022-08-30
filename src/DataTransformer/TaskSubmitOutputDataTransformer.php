<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\TaskSubmitOutput;
use App\Entity\TaskSubmit;

final class TaskSubmitOutputDataTransformer implements DataTransformerInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $output = $this->createFakeObject($data);
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return TaskSubmitOutput::class === $to && $data instanceof TaskSubmit;
    }

    private function createFakeObject($data)
    {
        $output = new TaskSubmitOutput();

        $output->id = $data->getId();
        $output->evaluated = $data->getEvaluated();
        $output->testList = $this->getFakeTestList();
        $output->errorList = $this->getFakeErrorList();
        $output->score = $data->getScore();
        $output->codeLanguage = $data->getCodeLanguage()->getFullName();
        $output->uploadDate = $data->getUploadDate()->format("Y-m-d H:i:s");

        return $output;
    }

    private function getFakeTestList()
    {
        $fakeTestList = [
            [
                "id" => 1,
                "points" => 1,
                "expectedMethod" => "int ReturnMax(int[] array)",
                "executedMethod" => "int ReturnMax( [6, 3, 1, 9, 2] )",
                "expectedValue" => "9"
            ],
            [
                "id" => 2,
                "points" => 1,
                "expectedMethod" => "int ReturnMax(int[] array)",
                "executedMethod" => "int ReturnMax( [6, 3, 1, 9, 2] )",
                "expectedValue" => "9"
            ],
            [
                "id" => 3,
                "points" => 1,
                "expectedMethod" => "int ReturnMax(int[] array)",
                "executedMethod" => "int ReturnMax( [6, 3, 1, 9, 2] )",
                "expectedValue" => "9"
            ],
            [
                "id" => 4,
                "points" => 0,
                "expectedMethod" => "int ReturnMax(int[] array)",
                "executedMethod" => "int ReturnMax( [6, 3, 1, 2, 9] )",
                "expectedValue" => "9",
                "failureMessage" => "Index was outside the bounds of the array.",
                "failureExceptionType" => "IndexOutOfRangeException"
            ],
            [
                "id" => 5,
                "points" => 1,
                "expectedMethod" => "int ReturnMax(int[] array)",
                "executedMethod" => "int ReturnMax( [6, 3, 1, 9, 2] )",
                "expectedValue" => "9"
            ],
        ];
        return $fakeTestList;
    }

    private function getFakeErrorList()
    {
        $fakeErrorList = [
            [
                "line" => 9,
                "position" => 1,
                "type" => "warning",
                "id" => "CS0219",
                "message" => "Unused variable."
            ],
            [
                "line" => 13,
                "position" => 1,
                "type" => "error",
                "id" => "CS1002",
                "message" => "Missing semicolon."
            ]
        ];


        return $fakeErrorList;
    }
}
