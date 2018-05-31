<?php

namespace Aeris\Component\Report\Dashboard;

use Aeris\Component\Report\Graph\GraphQuantitesIncinerees;
use Aeris\Component\Report\Graph\GraphHeuresFonctionnement;

class GeneralReport {
    public $graphQtitesIncinerees;
    public $graphHeuresFonctionnement;

    public $cumulQtitesIncinereesDebutAnnee;
    public $dateDebutAnnee;

    public function __construct($incinerateur) {
        $now = new \DateTime;
        $this->dateDebutAnnee = \DateTime::createFromFormat('j-M-Y', sprintf('01-January-%s', $now->format('Y')));

        $this->graphQtitesIncinerees = new GraphQuantitesIncinerees($incinerateur);
        $this->graphHeuresFonctionnement = new GraphHeuresFonctionnement($incinerateur);
        $this->extraireCumulDepuisDebutAnnee($incinerateur);
    }

    private function extraireCumulDepuisDebutAnnee($incinerateur) {       
        $this->cumulQtitesIncinereesDebutAnnee = 0;
        $now = new \DateTime;

        foreach($incinerateur->getDeclarationsIncinerateur() as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            if($dateDeclaration > $this->dateDebutAnnee && $dateDeclaration < $now) {
                $dechets = $currDeclaration->getDeclarationDechets();
                $this->cumulQtitesIncinereesDebutAnnee += $dechets->getQtiteIncinereeTotale();
            }
        }
    }
}