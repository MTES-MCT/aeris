<?php

namespace Aeris\Component\Report\Dashboard;

use Aeris\Component\Report\GraphMetadata;
use Aeris\Component\Report\GraphData;

class LineReport {
    public $graphs;
    public $metadata = [];

    const graphMapping = [
        'psr_c_24h_moy',
        'co_c_24h_moy',
        'cot_c_24h_moy',
        'hcl_c_24h_moy',
        'hf_c_24h_moy',
        'so2_c_24h_moy',
        'nox_c_24h_moy',
        'nh3_c_24h_moy'
    ];

    public function __construct($incinerateur) {
        $this->graphs = [];
        $measuresByLine = [];
        $this->configureMetadata();

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

        // Formatting of the data for display in graphs
        foreach($incinerateur->getLignes() as $currLine) {
            $measures = [];
            foreach(self::graphMapping as $currentGraph) {
                $this->graphs[$currLine->getNumero()][$currentGraph] = new GraphData($currentGraph, $measuresByLine[$currLine->getNumero()]);
            }
        }
    }

    private function configureMetadata(){
        $this->metadata = [
            'psr_c_24h_moy' => new GraphMetadata(
                10,
                'Poussières',
                'Concentration moyenne 24h',
                'mg/m^3.'
            ),
            'co_c_24h_moy' => new GraphMetadata(
                50,
                'CO',
                'Concentration moyenne 24h',
                'mg/m^3.'
            ),
            'cot_c_24h_moy' => new GraphMetadata(
                10,
                'COT',
                'Concentration moyenne 24h',
                'mg/m3'
            ),
            'hcl_c_24h_moy' => new GraphMetadata (
                10,
                'HCl',
                'Concentration moyenne 24h',
                'mg/m^3.'
            ),
            'hf_c_24h_moy' => new GraphMetadata (
                1,
                'HF',
                'Concentration moyenne 24h',
                'mg/m^3.'
            ),
            'so2_c_24h_moy' => new GraphMetadata (
                50,
                'SO2',
                'Concentration moyenne 24h',
                'mg/m^3.'
            ),
            'nox_c_24h_moy' => new GraphMetadata (
                200,
                'NOx',
                'Concentration moyenne 24h',
                'mg/m^3.'
            ),
            'nh3_c_24h_moy' => new GraphMetadata (
                30,
                'NH3',
                'Concentration moyenne 24h',
                'mg/m^3.'
            )
        ];
    }
}