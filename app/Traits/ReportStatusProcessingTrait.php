<?php

namespace App\Traits;

use App\Enums\ReportStatusEnum;
use App\Enums\ReportTypeEnum;
use App\Interfaces\ReportInterface;

trait ReportStatusProcessingTrait
{
    public function selectStatus(ReportInterface $report): string|null
    {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (strpos($method, 'is') === 0 &&
                strpos($method, 'Status') !== false &&
                is_callable([$this, $method])
            ) {
                $result = $this->$method($report);
                if (is_string($result)) {
                    return $result;
                }
            }
        }

        return ReportStatusEnum::STATUS_NEW->value;
    }

    private function isScheduledStatus(ReportInterface $report): false|string
    {
        if ($report->getType() === ReportTypeEnum::TYPE_OVERVIEW->value &&
            $report->getVisitDate() !== null
        ) {
            return ReportStatusEnum::STATUS_SCHEDULED->value;
        }

        return false;
    }

    private function isDeadlineStatus(ReportInterface $report): false|string
    {
        if ($report->getType() === ReportTypeEnum::TYPE_WARNING->value &&
            $report->getVisitDate() !== null
        ) {
            return ReportStatusEnum::STATUS_DEADLINE->value;
        }

        return false;
    }
}
