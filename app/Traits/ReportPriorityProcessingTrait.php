<?php

namespace App\Traits;

use App\Enums\ReportPriorityEnum;
use App\Interfaces\ReportInterface;
use App\Models\Report;

trait ReportPriorityProcessingTrait
{
    public array $highPriorityWords = [
        'pilne'
    ];
    public array $criticalPriorityWords = [
        'bardzo pilne'
    ];

    public function selectPriority(ReportInterface $report): string|null
    {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (strpos($method, 'is') === 0 &&
                strpos($method, 'Priority') !== false &&
                is_callable([$this, $method])
            ) {
                $result = $this->$method($report);
                if (is_string($result)) {
                    return $result;
                }
            }
        }

        return ReportPriorityEnum::PRIORITY_NORMAL->value;
    }

    private function isHighPriority(ReportInterface $report): false|string
    {
        if (preg_match($this->generateRegexForWords($this->highPriorityWords), $report->getDescription())
            && preg_match($this->generateRegexForWords($this->criticalPriorityWords), $report->getDescription()) == 0
        ) {
            return ReportPriorityEnum::PRIORITY_HIGH->value;
        }

        return false;
    }

    private function isCriticalPriority(ReportInterface $report): false|string
    {
        if (preg_match($this->generateRegexForWords($this->criticalPriorityWords), $report->getDescription())) {
            return ReportPriorityEnum::PRIORITY_CRITICAL->value;
        }

        return false;
    }

    private function generateRegexForWords(array $strings): string
    {
        $regex = '';

        foreach ($strings as $key => $string) {
            $words = explode(' ', $string);
            $wordsWithRegex = '';
            foreach ($words as $key => $word) {
                if (isset($words[$key + 1])) {
                    $wordsWithRegex .= $word.'\s+';
                } else {
                    $wordsWithRegex .= $word;
                }
            }

            if (isset($strings[$key + 1])) {
                $regex .= '/(?:^|\W)\s*'.$wordsWithRegex.'\s*(?:$|\W)/iu|';
            } else {
                $regex .= '/(?:^|\W)\s*'.$wordsWithRegex.'\s*(?:$|\W)/iu';
            }
        }


        return $regex;
    }
}
