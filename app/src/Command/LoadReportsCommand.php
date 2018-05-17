<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\DeclarationIncinerateurRepository;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

use Aeris\Component\ReportParser\Parser\Dreal\ConcentrationParser as DrealConcentrationParser;
use Aeris\Component\ReportParser\Parser\Dreal\FluxParser as DrealFluxParser;
use Aeris\Component\ReportParser\Parser\Dreal\CompteursParser as DrealCompteursParser;


class LoadReportsCommand extends Command
{
    private $declarationRepository;
    private $propertyMapping;

    public function __construct(
        DeclarationIncinerateurRepository $declarationRepository,
        PropertyMappingFactory $propertyMapping    
    ) {
        $this->declarationRepository = $declarationRepository;
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

            $datapoints = $parser->parseFile($fullFilePath);
            var_dump($hasFile, $fullFilePath, $datapoints);
        }
    }
}