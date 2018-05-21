<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\DeclarationIncinerateurRepository;
use App\Repository\MesureRepository;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

use Aeris\Component\ReportParser\Parser\Dreal\ConcentrationParser as DrealConcentrationParser;
use Aeris\Component\ReportParser\Parser\Dreal\FluxParser as DrealFluxParser;
use Aeris\Component\ReportParser\Parser\Dreal\CompteursParser as DrealCompteursParser;

use Doctrine\ORM\EntityManager;
use App\Entity\Declaration\Mesure;

class LoadReportsCommand extends Command
{
    /** @var DeclarationIncinerateurRepository */
    private $declarationRepository;
    /** @var MesureRepository */
    private $mesureRepository;
    /** @var EntityManager */
    private $entityManager;
    /** @var PropertyMappingFactory */
    private $propertyMapping;

    public function __construct(
        DeclarationIncinerateurRepository $declarationRepository,
        MesureRepository $mesureRepository,
        EntityManager $entityManager,
        PropertyMappingFactory $propertyMapping    
    ) {
        $this->declarationRepository = $declarationRepository;
        $this->mesureRepository = $mesureRepository;
        $this->entityManager = $entityManager;
        $this->propertyMapping = $propertyMapping;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('aeris:loads-reports')
            ->setDescription('Loads the reports for a given user.')
            ->addArgument('declarationId', InputArgument::REQUIRED, 'The declaration identifier for which we want to import the data.')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $declarationId = $input->getArgument('declarationId');
        
        $declaration = $this->declarationRepository
            ->find($declarationId);
        if($declaration != null) {
            $output->writeln(sprintf('Importing data for declaration %s', $declarationId));
            foreach ($declaration->getDeclarationsFonctionnementLigne() as $declarationFonctionnementLigne) {
                $this->loadConcentrations($declarationFonctionnementLigne);
                $this->loadFlux($declarationFonctionnementLigne);
            }
        }
        else {
            $output->writeln(sprintf('No declaration %s', $declarationId));
        }
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