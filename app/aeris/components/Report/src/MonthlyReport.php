<?php

namespace Aeris\Component\Report;

class MonthlyReport {
    private $dailyData;

    private $countersValues;

    private $nbDaysInMonth;
    
    private $rules;

    public function __construct($month, $appliableRules) {
        $this->rules = $appliableRules;
        $this->dailyData = [];

        $this->nbDaysInMonth = $this->getNumberOfDays($month);
        for ($i = 1; $i <= $this->nbDaysInMonth; ++$i) {
            $this->dailyData[$i] = [];
            foreach ($this->rules->fields as $currentField) {
                $this->dailyData[$i][$currentField] = null;
            }
        }
    }

    public function fillWithMeasures($measures) {
        foreach ($measures as $measure) {
            $day = $this->getDay($measure->getDate());
            $type = $measure->getType();
            if($day >=  1 && $day <= $this->nbDaysInMonth && in_array($type, $this->rules->fields)) {
                var_dump(
                    $day,
                    $type,
                    $measure->getValue(), "\n");
                $this->dailyData[$day][$type] = (float)$measure->getValue();
            }
        }
    }

    public function debug($field){
        for($i = 1; $i<= $this->nbDaysInMonth; ++$i) {
            echo $i."\t".$this->dailyData[$i][$field]."\n";
        }
    }

    private function getNumberOfDays($month) {
         return (int)$month->format('t');
    }

    private function getDay($date) {
         return (int)$date->format('d');
    }
}