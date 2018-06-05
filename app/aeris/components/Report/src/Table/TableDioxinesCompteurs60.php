<?php

namespace Aeris\Component\Report\Table;
use Aeris\Component\Report\AppliableRules;

class TableDioxinesCompteurs60 {

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
    
    }
}