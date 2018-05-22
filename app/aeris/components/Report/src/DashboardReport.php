<?php

namespace Aeris\Component\Report;

class DashboardReport {
    public $graphs;
    private $measuresByLine;

    // const KEY_LINES = 'lines';

    const graphMapping = [
            'psr_c_24h_moy',
            'co_c_24h_moy'
        ];

    public function __construct($incinerateur) {
        $this->graphs = [];
        $measuresByLine = [];

        // Initialisations of the arrays we use afterwards
        foreach($incinerateur->getLignes() as $currLine) {
            $this->graphs[$currLine->getNumero()] = [];
            $measuresByLine[$currLine->getNumero()] = [];
        }

        // Preparation of the data
        foreach($incinerateur->getDeclarationsIncinerateur() as $currDeclaration) {
            foreach ($currDeclaration->getDeclarationsFonctionnementLigne() as $currDeclarationFonctionnement) {
                $offset = (string)$currDeclarationFonctionnement->getLigne()->getNumero();
                $measuresByLine[$offset] = array_merge(
                    $measuresByLine[$offset],
                    $currDeclarationFonctionnement->getMesures()->toArray()
                );
            }
        }
        $this->measuresByLine = $measuresByLine;

        // Formatting of the data for display in graphs
        foreach($incinerateur->getLignes() as $currLine) {
            $measures = [];
            foreach(self::graphMapping as $currentGraph) {
                $this->graphs[$currLine->getNumero()][$currentGraph] = new GraphData($currentGraph, $this->measuresByLine[$currLine->getNumero()]);
            }
        }
    }


}