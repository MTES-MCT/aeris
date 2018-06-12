<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\DeclarationIncinerateurRepository;

class SendMailCommand extends Command
{
    private $declarationRepository;

    private $mailer;

    private $mailFactory;

    public function __construct(
        DeclarationIncinerateurRepository $declarationRepository,
        $mailer,
        $mailFactory
    ) {
        $this->declarationRepository = $declarationRepository;
        $this->mailer = $mailer;
        $this->mailFactory = $mailFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('aeris:send-mail')
            ->setDescription('Sends an email for a given declaration.')
            ->addArgument('declarationId', InputArgument::REQUIRED, 'The declaration identifier we want to check.')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $declarationId = $input->getArgument('declarationId');
        
        $declaration = $this->declarationRepository
            ->find($declarationId);
        if ($declaration != null) {
            $mail = $this->mailFactory->createNewDeclarationInspecteurMessage($declarationId);

            $response = $this->mailer->send($mail);
            if ($response->success()) {
                var_dump($response->getData());
            }
        }
        else {
            $output->writeln(sprintf('No declaration %s', $declarationId));
        }
    }
}