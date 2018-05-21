<?php

namespace Aeris\Component\Report;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Aeris\Component\Report\Validator as Assert;

class MonthlyReport {
    public $dailyData;

    private $countersValues;

    public $nbDaysInMonth;
    
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Assert\IsInMonthlyRange('nox_c_24h_moy', 4, 10));
    }
}