<?php

namespace Aeris\Component\Report\Graph;

use App\Entity\Incinerateur;
use App\Repository\DeclarationIncinerateurRepository;

class GraphHeuresFonctionnement {
    public $months;
    public $data;
    public $heuresTheoriques;
    public $lignes;

    private $firstDate;

    private $declarationRepository;

    public function __construct(
        Incinerateur $incinerateur,
        DeclarationIncinerateurRepository $declarationRepository
    ) {
        $this->declarationRepository = $declarationRepository;
        // We want to display 6 months of data
        $this->firstDate = new \DateTime('-5 months');
        $this->firstDate->modify('first day of this month');
        $this->firstDate->setTime(0, 0, 0);

        $this->prepareListOfMonths($incinerateur);
        $this->prepareData($incinerateur);
    }

    private function prepareListOfMonths($incinerateur){
        $this->months = [];
        $this->data = [];
        $this->lignes = [];
        $this->heuresTheoriques = [];

        $iterator = new \DatePeriod(
             $this->firstDate,
             new \DateInterval('P1M'),
             new \DateTime('+1 month')
        );

        foreach($incinerateur->getLignes() as $currentLigne) {
            $this->data[$currentLigne->getNumero()] = [];
            $this->lignes[] = $currentLigne->getNumero();
        }

        foreach($iterator as $currentDate) {
            $currDate = $this->formatDate($currentDate);
            $this->months[] = $currDate;
            $this->heuresTheoriques[] = 24 * (int)$currentDate->format('t');
            foreach($incinerateur->getLignes() as $currentLigne) {
                $this->data[$currentLigne->getNumero()][] = 0;
            }
        }
    }

    private function formatDate($date) {
        return $date->format("m/Y");
    }

    private function prepareData($incinerateur) {
        $now = new \DateTime;
        $declarations = $this->declarationRepository
            ->findValidatedDeclarations($incinerateur);

        foreach($declarations as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            if($dateDeclaration >= $this->firstDate && $dateDeclaration < $now) {
                $dechets = $currDeclaration->getDeclarationDechets();
                $declarationMonth = $this->formatDate($dateDeclaration);
                $timeDifference = $dateDeclaration->diff($this->firstDate);
                $index = $timeDifference->m;

                foreach($currDeclaration->getDeclarationsFonctionnementLigne() as $declFonctionnement){
                    $ligne = $declFonctionnement->getLigne()->getNumero();
                    $heuresFonctionnement = $declFonctionnement->getNbHeuresFonctionnementReel();
                    $this->data[$ligne][$index] = $heuresFonctionnement;
                }
                // $this->data[$index] = $dechets->getQtiteIncinereeTotale();
                // $this->data[$nbDaysDate->days] = $measure->getValue()
            }
        }
    }
}