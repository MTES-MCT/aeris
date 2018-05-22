<?php

namespace Aeris\Component\Report;

class DashboardReport {
    private $graphs;

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
            $this->measuresByLine[$currLine->getNumero()] = [];
        }

        // Preparation of the data
        

        // Formatting of the data for display in graphs
        foreach($incinerateur->getLignes() as $currLine) {
            foreach(self::graphMapping as $currentGraph) {
                // $this->graphs[$currLine->getNumero()][$currentGraph] = new GraphData($currentGraph, $measures);
            }
        }
    }


}