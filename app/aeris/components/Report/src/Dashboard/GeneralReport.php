<?php

namespace Aeris\Component\Report\Dashboard;

use App\Entity\Incinerateur;
use App\Repository\DeclarationIncinerateurRepository;
use Aeris\Component\Report\Graph\GraphQuantitesIncinerees;
use Aeris\Component\Report\Graph\GraphHeuresFonctionnement;
use Aeris\Component\Report\DateUtils;

class GeneralReport {
    private $declarationRepository;

    public $graphQtitesIncinerees;
    public $graphHeuresFonctionnement;

    public $cumulQtitesIncinereesDebutAnnee;
    public $dateDebutAnnee;

    public function __construct(
        DeclarationIncinerateurRepository $declarationRepository,
        Incinerateur $incinerateur
    ) {
        $this->declarationRepository = $declarationRepository;
        $this->dateDebutAnnee = DateUtils::getFirstOfJanuaryThisYear();

        $this->graphQtitesIncinerees = new GraphQuantitesIncinerees(
                $incinerateur,
                $this->declarationRepository
            );
        $this->graphHeuresFonctionnement = new GraphHeuresFonctionnement(
            $incinerateur,
            $this->declarationRepository
        );
        $this->extraireCumulDepuisDebutAnnee($incinerateur);
    }

    private function extraireCumulDepuisDebutAnnee($incinerateur) {       
        $this->cumulQtitesIncinereesDebutAnnee = 0;
        $now = new \DateTime();

        $declarations = $this->declarationRepository
            ->findValidatedDeclarations($incinerateur);

        foreach($declarations as $currDeclaration) {
            $dateDeclaration = $currDeclaration->getDeclarationMonth();
            if($dateDeclaration > $this->dateDebutAnnee && $dateDeclaration < $now) {
                $dechets = $currDeclaration->getDeclarationDechets();
                $this->cumulQtitesIncinereesDebutAnnee += $dechets->getQtiteIncinereeTotale();
            }
        }
    }
}