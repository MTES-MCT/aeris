<?php

namespace Aeris\Component\Report\Graph;

class TableCompteursAnnuel {
    public $measures;

    public $lignes;
    public $colonnes;

    public function __construct($incinerateur) {
        $this->measures = [];
        $this->lignes = AppliableRules::compteursTypes;
        $this->colonnes = AppliableRules::compteursComponents;

        foreach($this->lignes as $type) {
            $this->measures[$type] = [];
            foreach($this->colonnes as $colonne) {
                $this->measures[$type][$colonne] = 4;
            }
        }
    }
}