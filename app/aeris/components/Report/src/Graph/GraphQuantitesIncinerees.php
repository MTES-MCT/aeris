<?php

namespace Aeris\Component\Report\Graph;

class GraphQuantitesIncinerees {
    public $months;
    public $data;
    public $measures;

    private $firstDate;

    public function __construct($incinerateur) {
        // We want to display 6 months of data
        $this->firstDate = new \DateTime('-5 months');

        $this->prepareListOfMonths();
        $this->prepareData($incinerateur);
    }

    private function prepareListOfMonths(){
        $this->months = [];
        $this->data = [];

        $iterator = new \DatePeriod(
             $this->firstDate,
             new \DateInterval('P1M'),
             new \DateTime('+1 month')
        );

        foreach($iterator as $currentDate) {
            $currDate = $this->formatDate($currentDate);
            $this->months[] = $currDate;
            $this->data[] = 0;
        }
    }

    private function formatDate($date) {
        return $date->format("m/Y");
    }

    private function prepareData($incinerateur) {
        $now = new \DateTime;
        foreach($incinerateur->getDeclarationsIncinerateur() as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            if($dateDeclaration > $this->firstDate && $dateDeclaration < $now) {
                $dechets = $currDeclaration->getDeclarationDechets();
                $declarationMonth = $this->formatDate($dateDeclaration);
                $timeDifference = $dateDeclaration->diff($this->firstDate);
                $index = $timeDifference->m;

                $this->data[$index] = $dechets->getQtiteIncinereeTotale();
                // $this->data[$nbDaysDate->days] = $measure->getValue()
            }
        }
    }
}