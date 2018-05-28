<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\DeclarationIncinerateurRepository;
use App\Repository\MesureRepository;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

use Aeris\Component\ReportParser\Parser\Dreal\CompteurParser as DrealCompteurParser;
use Aeris\Component\ReportParser\Parser\Dreal\CompteurDataPoint;

use Doctrine\ORM\EntityManager;
use App\Entity\Declaration\Mesure;
use App\Entity\Declaration\MesureCompteur;

class LoadCounterReportsCommand extends Command
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
            ->setName('aeris:loads-counter-reports')
            ->setDescription('Loads the counter reports for a given user.')
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
                $this->loadCompteurs($declarationFonctionnementLigne);
            }
        }
        else {
            $output->writeln(sprintf('No declaration %s', $declarationId));
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
            $this->loadDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne);
        }
    }

    private function loadDataPoints($parser, $fullFilePath, $declarationFonctionnementLigne) {
        $datapoints = $parser->parseFile($fullFilePath);

        foreach($datapoints as $datapoint){
            $mesure = MesureCompteur::fromCompteurDataPoint($datapoint);
            $mesure->setDeclarationFonctionnementLigne($declarationFonctionnementLigne);
            $this->entityManager->persist($mesure);
        }

        $this->entityManager->flush();
    }
}