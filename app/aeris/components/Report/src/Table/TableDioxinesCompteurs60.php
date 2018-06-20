<?php

namespace Aeris\Component\Report\Table;

use Aeris\Component\Report\DateUtils;
use App\Entity\Incinerateur;
use App\Repository\DeclarationIncinerateurRepository;
use App\Repository\DeclarationDioxineRepository;

class TableDioxinesCompteurs60 {
    public $dioxinesDernierMois;
    public $nbDepassementDioxinesAnnee;

    private $declarationDioxineRepository;

    public function __construct(
        Incinerateur $incinerateur,
        $ligneId,
        DeclarationDioxineRepository $repository
    ) {
        $this->dioxinesDernierMois = 0;
        $this->nbDepassementDioxinesAnnee = 0;
        $this->declarationDioxineRepository = $repository;
        $this->analyzeDeclarations($incinerateur, $ligneId);
    }

    private function analyzeDeclarations($incinerateur, $ligneId) {
        $declarations = $this->declarationDioxineRepository
            ->findValidatedDeclarations($incinerateur);

        foreach($declarations as $currDeclaration) {
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