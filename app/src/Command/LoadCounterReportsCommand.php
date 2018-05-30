<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\DeclarationIncinerateurRepository;
use Aeris\Component\ReportParser\DeclarationImporter;

class LoadCounterReportsCommand extends Command
{
    /** @var DeclarationIncinerateurRepository */
    private $declarationRepository;
    /** @var DeclarationImporter */
    private $declarationImporter;

    public function __construct(
        DeclarationIncinerateurRepository $declarationRepository,
        DeclarationImporter $declarationImporter
    ) {
        $this->declarationRepository = $declarationRepository;
        $this->declarationImporter = $declarationImporter;
        

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

        foreach ($declaration->getDeclarationsFonctionnementLigne() as $declarationFonctionnementLigne) {
                $this->loadCompteurs($declarationFonctionnementLigne);
            }
    }    
}