<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\DeclarationIncinerateurRepository;

use Aeris\Component\Report\AppliableRules;
use Aeris\Component\Report\MonthlyReport;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateReportCommand extends Command
{
    /** @var DeclarationIncinerateurRepository */
    private $declarationRepository;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        DeclarationIncinerateurRepository $declarationRepository,
        ValidatorInterface $validator
    ) {
        $this->declarationRepository = $declarationRepository;
        $this->validator = $validator;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('aeris:validate-report')
            ->setDescription('Checks the data in the report for a given user.')
            ->addArgument('declarationId', InputArgument::REQUIRED, 'The declaration identifier we want to check.')
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
                if(!empty($declarationFonctionnementLigne->getMesures())) {
                    $this->checkDeclarationFonctionnementLigne(
                        $declaration,
                        $declarationFonctionnementLigne
                    );
                }
            }
        }
        else {
            $output->writeln(sprintf('No declaration %s', $declarationId));
        }
    }

    private function checkDeclarationFonctionnementLigne(
        $declaration,
        $declarationLigne) {
        $rules = new AppliableRules();

        $report = new MonthlyReport($declaration->getDeclarationMonth(), $rules);
        $report->fillWithMeasures($declarationLigne->getMesures());
        
        $errors = $this->validator->validate($report);
        $report->debug('nox_c_24h_moy');
        var_dump($errors);
    }
}