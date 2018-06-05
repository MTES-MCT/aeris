<?php

namespace Aeris\Component\Report\Table;

use Aeris\Component\Report\DateUtils;

class TableDioxinesCompteurs60 {

    const MEASURE_COMPTEUR_60H = 'compt_art10_mensuel';

    public $compteur60DernierMois;
    public $dioxinesDernierMois;
    
    public $compteur60Annuel;
    public $dioxinesAnnuel;

    public function __construct($incinerateur, $ligneId) {
        $this->compteur60DernierMois = 0;
        $this->dioxinesDernierMois = 0;
        $this->compteur60Annuel = 0;
        $this->dioxinesAnnuel = 0;

        $this->analyzeDeclarations($incinerateur, $ligneId);
    }

    private function analyzeDeclarations($incinerateur, $ligneId) {
        $currentYear = DateUtils::getFirstOfJanuaryThisYear();
        foreach($incinerateur->getDeclarationsIncinerateur() as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            if($dateDeclaration < $currentYear){
                continue;
            }
            
            foreach($currDeclaration->getDeclarationsFonctionnementLigne() as $declLigne) {
                if($declLigne->getLigne()->getNumero() == $ligneId) {
                    $this->extractCounterValues($declLigne->getMesuresCompteurs());
                }
            }
        }
    }

    private function extractCounterValues($measures){
        $currentYear = DateUtils::getFirstOfJanuaryThisYear();

        foreach($measures as $measure) {
            if($measure->getType() == self::MEASURE_COMPTEUR_60H && $measure->getComponent() == 'Total') {
                $this->compteur60Annuel += $measure->getValue();
            }
            
        }
    }


}