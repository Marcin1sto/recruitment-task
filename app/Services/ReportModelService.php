<?php

namespace App\Services;

use App\Enums\ReportTypeEnum;
use App\Interfaces\ReportInterface;
use App\Models\NotAssignedReport;
use App\Models\OverviewReport;
use App\Models\WarningReport;
use App\Traits\ReportPriorityProcessingTrait;
use App\Traits\ReportStatusProcessingTrait;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReportModelService
{
    use ReportPriorityProcessingTrait;
    use ReportStatusProcessingTrait;

    public array $typePerModel = [
        ReportTypeEnum::TYPE_OVERVIEW->value => OverviewReport::class,
        ReportTypeEnum::TYPE_WARNING->value => WarningReport::class,
        ReportTypeEnum::TYPE_NOT_ASSIGNED->value => NotAssignedReport::class,
    ];

    private array $keysToReplace = [
        'phone' => 'contactNumber',
        'dueDate' => 'visitDate',
    ];

    public function createModel(array $data, string $type): ReportInterface
    {
        // Encoder and normalizer configuration
        $normalizers = [new ObjectNormalizer(), new DateTimeNormalizer(), new ArrayDenormalizer()];

        // Creating a Serializer instance
        $serializer = new Serializer($normalizers, []);

        $data = $this->changeArrayKeys($data);

        $model = $serializer->denormalize($data, $this->typePerModel[$type]);

        $model->setType($type);

        // check if method setPriority exists
        if (method_exists($model, 'setPriority')) {
            $model->setPriority($this->selectPriority($model));
        }

        // setStatus is defined in ReportInterface
        $model->setStatus($this->selectStatus($model));

        $model = $this->setUniqueParams($model);

        return $model;
    }

    private function changeArrayKeys($array): array
    {
        $keys = array_keys($array);

        foreach ($this->keysToReplace as $key => $newKey) {
            if (!array_key_exists($key, $this->keysToReplace)) {
                continue;
            }

            $keys[array_search($key, $keys)] = $newKey;
        }

        return array_combine($keys, $array);
    }

    private function setUniqueParams(ReportInterface $model): ReportInterface
    {
        $methods = get_class_methods($model);
        $uniqueParams = $model::UNIQUE_PARAMS;
        $uniqueParams = array_map('ucfirst', $uniqueParams);
        if (!empty($uniqueParams)) {
            $regex = '(' . implode('|', array_map('preg_quote', $uniqueParams)) . ')';

            foreach ($methods as $method) {
                if (strpos($method, 'set') === 0 &&
                    preg_match($regex, $method) &&
                    is_callable([$model, $method])
                ) {
                    $model->$method(null);
                }
            }
        }

        return $model;
    }
}
