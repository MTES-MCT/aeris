<?php

namespace Aeris\Component\Report;

class GraphData {
    private $measureType;

    private $days;
    private $data;

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
            $this->days[] = $currentDate;
            $this->data[] = 0;
        }
    }

    private function prepareData($type, $measures) {

    }
}