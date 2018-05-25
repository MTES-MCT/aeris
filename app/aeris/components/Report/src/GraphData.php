<?php

namespace Aeris\Component\Report;

class GraphData {
    public $measureType;
    public $days;
    public $data;
    public $measures;

    public function __construct($measureType, $measures) {
        // We want to display 6 months of data
        $this->firstDate = new \DateTime('-6 months');
        $this->measureType = $measureType;

        $this->prepareListOfDays();
        $this->prepareData($measureType, $measures);
    }

    private function prepareListOfDays(){
        $this->days = [];
        $this->data = [];

        $iterator = new \DatePeriod(
             $this->firstDate,
             new \DateInterval('P1D'),
             new \DateTime()
        );

        foreach($iterator as $currentDate) {
            $currDate = $currentDate->format("d/m/Y");
            $this->days[] = $currDate;
            $this->data[] = 0;
        }
    }

    private function prepareData($type, $measures) {
        foreach($measures as $measure) {
            if($measure->getType() == $type && $measure->getDate() > $this->firstDate) {
                $nbDaysDate = date_diff($measure->getDate(), $this->firstDate);
                if ($nbDaysDate->days < count($this->data)) {
                    $this->data[$nbDaysDate->days] = $measure->getValue();
                }
            }
        }
    }
}