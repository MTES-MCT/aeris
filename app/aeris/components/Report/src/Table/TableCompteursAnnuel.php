<?php

namespace Aeris\Component\Report\Table;
use Aeris\Component\Report\AppliableRules;

class TableCompteursAnnuel {
    public $measures;

    public $lignes;
    public $colonnes;

    public function __construct($incinerateur, $ligneId) {
        $this->setup();
        $this->analyzeDeclarations($incinerateur, $ligneId);
    }

    private function setup(){
        $this->measures = [];
        $this->lignes = AppliableRules::compteursTypes;
        $this->colonnes = AppliableRules::compteursComponents;

        foreach($this->lignes as $type) {
            $this->measures[$type] = [];
            foreach($this->colonnes as $colonne) {
                $this->measures[$type][$colonne] = 0;
            }
        }

    }

    private function analyzeDeclarations($incinerateur, $ligneId) {
        foreach($incinerateur->getDeclarationsIncinerateur() as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            
            foreach($currDeclaration->getDeclarationsFonctionnementLigne() as $declLigne) {
                if($declLigne->getLigne()->getNumero() == $ligneId) {
                    $this->extractCounterValues($declLigne->getMesuresCompteurs());
                }
            }
        }
    }

    private function extractCounterValues($measures){
        foreach($measures as $measure) {
            $this->measures[$measure->getType()][$measure->getComponent()] = $measure->getValue();
            // if(in_array($measure->getType(), $this->lignes)
            //     && in_array($measure->getComponent(), $this->colonnes)) {

            // }
        }
    }
}