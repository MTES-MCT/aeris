<?php

namespace Aeris\Component\Report;

class MonthlyReport {
    private $dailyData;

    private $countersValues;
    
    public function __construct($month, $appliableRules) {
        $this->dailyData = [];
        $nbDaysInMonth = $month->format('t');
        for ($i = 1; $i < $nbDaysInMonth; ++$i) {
            $this->dailyData[$i] = [];
            foreach ($appliableRules->fields as $currentField) {
                $this->dailyData[$i][$currentField] = null;
            }
        }
    }
}