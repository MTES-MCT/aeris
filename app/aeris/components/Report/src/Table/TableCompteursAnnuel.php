<?php

namespace Aeris\Component\Report\Table;
use Aeris\Component\Report\AppliableRules;

class TableCompteursAnnuel {
    public $measures;

    public $lignes;
    public $colonnes;

    public function __construct($incinerateur, $ligneId) {
        $this->setup();
        $this->extractCounterValues($incinerateur, $ligneId);
    }

    private function setup(){
        $this->measures = [];
        $this->lignes = AppliableRules::compteursTypes;
        $this->colonnes = AppliableRules::compteursComponents;

        foreach($this->lignes as $type) {
            $this->measures[$type] = [];
            foreach($this->colonnes as $colonne) {
                $this->measures[$type][$colonne] = 8;
            }
        }
    }

    private function extractCounterValues($incinerateur, $ligneId) {
        foreach($incinerateur->getDeclarationsIncinerateur() as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            
            // foreach($incinerateur->getDeclarationLigne() as $declLigne) {
            //     if($declLigne->getNumero == $ligneId) {
                    
            //     }
            // }
        }
    }
}