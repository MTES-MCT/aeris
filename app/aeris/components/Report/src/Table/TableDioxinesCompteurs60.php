<?php

namespace Aeris\Component\Report\Table;

use Aeris\Component\Report\DateUtils;
use App\Entity\Incinerateur;
use App\Repository\DeclarationIncinerateurRepository;

class TableDioxinesCompteurs60 {
    public $dioxinesDernierMois;
    public $nbDepassementDioxinesAnnee;

    public function __construct(
        Incinerateur $incinerateur, $ligneId) {
        $this->dioxinesDernierMois = 0;
        $this->nbDepassementDioxinesAnnee = 0;
        $this->analyzeDeclarations($incinerateur, $ligneId);
    }

    private function analyzeDeclarations($incinerateur, $ligneId) {
        foreach($incinerateur->getDeclarationsDioxine() as $currDeclaration) {
            $this->extractDioxinesValues($currDeclaration->getMesuresDioxine(), $ligneId);
        }
    }

    private function extractDioxinesValues($measures, $ligneId){
        $firstValidDate = DateUtils::getFirstOfJanuaryThisYear();
        $mostRecentDate = null;
        $this->dioxinesDernierMois = 0;

        foreach($measures as $measure) {
            if($measure->getDateDebut() >= $firstValidDate && $measure->getLigne()->getNumero() == $ligneId){
                if($measure->getConcentration() > 0.1) {
                    $this->nbDepassementDioxinesAnnee++;
                }
                if($mostRecentDate == null or $mostRecentDate < $measure->getDateDebut()) {
                    $mostRecentDate = $measure->getDateDebut();
                    $this->dioxinesDernierMois = $measure->getConcentration();
                }
            }
        }
    }
}