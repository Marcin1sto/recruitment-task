<?php

namespace App\Traits;

use App\Enums\ReportTypeEnum;

trait ReportTypeProcessingTrait
{
    private const POLISH_WORD_REGEX = '/(p|P)(r|R)(z|Ż|Ź|Z)(e|ę|E|Ę)(g|G)(l|ł|L|Ł)(a|ą|A|Ą)(d|D)/';

    public function selectType(array $reportContent): string
    {
        if (!$this->checkIsDuplicate($reportContent)) {
            $methods = get_class_methods($this);
            foreach ($methods as $method) {
                if (strpos($method, 'is') === 0 &&
                    strpos($method, 'Type') !== false &&
                    is_callable([$this, $method])
                ) {
                    $result = $this->$method($reportContent);
                    if (is_string($result)) {
                        return $result;
                    }
                }
            }
        }

        return ReportTypeEnum::TYPE_NOT_ASSIGNED->value;
    }

    private function isWarningType(array $report): false|string
    {
        $description = $report['description'];

        $regex = self::POLISH_WORD_REGEX;
        $result = preg_match($regex, $description);

        return $result === 0 ? ReportTypeEnum::TYPE_WARNING->value : false;
    }

    private function isOverviewType(array $report): false|string
    {
        $description = $report['description'];

        $regex = self::POLISH_WORD_REGEX;
        $result = preg_match($regex, $description);

        return $result === 1 ? ReportTypeEnum::TYPE_OVERVIEW->value : false;
    }

    private function checkIsDuplicate(array $report): bool
    {
        if (isset($report['isDuplicate']) && $report['isDuplicate']) {
            return true;
        }

        return false;
    }
}
