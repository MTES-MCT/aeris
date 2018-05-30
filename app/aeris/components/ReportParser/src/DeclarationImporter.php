<?php

namespace Aeris\Component\ReportParser;

use App\Repository\DeclarationIncinerateurRepository;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

use Aeris\Component\ReportParser\Parser\Dreal\CompteurParser as DrealCompteurParser;
use Aeris\Component\ReportParser\Parser\Dreal\ConcentrationParser as DrealConcentrationParser;
use Aeris\Component\ReportParser\Parser\Dreal\FluxParser as DrealFluxParser;
use Aeris\Component\ReportParser\Parser\Dreal\CompteurDataPoint;

use Doctrine\ORM\EntityManager;
use App\Entity\Declaration\Mesure;
use App\Entity\Declaration\MesureCompteur;

class DeclarationImporter {
    /** @var EntityManager */
    private $entityManager;
    /** @var PropertyMappingFactory */
    private $propertyMapping;

    public function __construct(
        EntityManager $entityManager,
        PropertyMappingFactory $propertyMapping    
    ) {
        $this->entityManager = $entityManager;
        $this->propertyMapping = $propertyMapping;
    }

    public function loadDeclaration ($declaration) {
        if($declaration != null) {
            foreach ($declaration->getDeclarationsFonctionnementLigne() as $declarationFonctionnementLigne) {
                $this->loadCompteurs($declarationFonctionnementLigne);
                $this->loadConcentrations($declarationFonctionnementLigne);
                $this->loadFlux($declarationFonctionnementLigne);
            }
        }
    }

    private function loadCompteurs($declarationFonctionnementLigne) {
        $filename = $declarationFonctionnementLigne->getDeclarationCompteursFileName();
        $hasFile = !empty($filename);
        if($hasFile) {
            $mapping = $this->propertyMapping->fromField($declarationFonctionnementLigne, 'declarationCompteursFile');

            $uploadDestination = $mapping->getUploadDestination();
            $fullFilePath = $uploadDestination.'/'.$filename;

            $parser = new DrealCompteurParser();
            $this->loadCompteursDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne);
        }
    }

    private function loadCompteursDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne) {
        $datapoints = $parser->parseFile($fullFilePath);

        foreach($datapoints as $datapoint){
            $mesure = MesureCompteur::fromCompteurDataPoint($datapoint);
            $mesure->setDeclarationFonctionnementLigne($declarationFonctionnementLigne);
            $this->entityManager->persist($mesure);
        }

        $this->entityManager->flush();
    }


    private function loadConcentrations($declarationFonctionnementLigne) {
        $filename = $declarationFonctionnementLigne->getDeclarationConcentrationsFileName();
        $hasFile = !empty($filename);
        if($hasFile) {
            $mapping = $this->propertyMapping->fromField($declarationFonctionnementLigne, 'declarationConcentrationsFile');

            $uploadDestination = $mapping->getUploadDestination();
            $fullFilePath = $uploadDestination.'/'.$filename;

            $parser = new DrealConcentrationParser();
            $this->loadDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne);
        }
    }

    private function loadFlux($declarationFonctionnementLigne) {
        $filename = $declarationFonctionnementLigne->getDeclarationFluxFileName();
        $hasFile = !empty($filename);
        if($hasFile) {
            $mapping = $this->propertyMapping->fromField($declarationFonctionnementLigne, 'declarationFluxFile');

            $uploadDestination = $mapping->getUploadDestination();
            $fullFilePath = $uploadDestination.'/'.$filename;

            $parser = new DrealFluxParser();
            $this->loadDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne);
        }
    }

    private function loadDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne) {
        $datapoints = $parser->parseFile($fullFilePath);

        foreach($datapoints as $datapoint){
            $mesure = Mesure::fromDataPoint($datapoint);
            $mesure->setDeclarationFonctionnementLigne($declarationFonctionnementLigne);
            $this->entityManager->persist($mesure);
        }

        $this->entityManager->flush();
    }
}