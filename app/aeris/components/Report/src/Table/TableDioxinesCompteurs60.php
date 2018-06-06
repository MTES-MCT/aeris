<?php

namespace Aeris\Component\Report\Table;

use Aeris\Component\Report\DateUtils;

class TableDioxinesCompteurs60 {
    public $dioxinesDernierMois;
    public $dioxinesAnnuel;

    public function __construct($incinerateur, $ligneId) {
        $this->dioxinesDernierMois = 0;
        $this->dioxinesAnnuel = 0;
        $this->analyzeDeclarations($incinerateur, $ligneId);
    }

    private function analyzeDeclarations($incinerateur, $ligneId) {
        foreach($incinerateur->getDeclarationsDioxine() as $currDeclaration) {
            $this->extractDioxinesValues($currDeclaration->getMesuresDioxine(), $ligneId);
        }
    }

    private function extractDioxinesValues($measures, $ligneId){
        $firstValidDate = DateUtils::getFirstOfJanuaryThisYear();

        foreach($measures as $measure) {
            if($measure->getDateDebut() >= $firstValidDate){
                $this->dioxinesAnnuel += $measure->getValue();
            }
        }
    }
}