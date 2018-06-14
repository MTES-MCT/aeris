<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use FOS\UserBundle\Doctrine\UserManager as UserRepository;
use Aeris\Component\ReportParser\DeclarationImporter;

use App\Entity\IncinerateurLigne;
use App\Entity\Incinerateur;
use App\Entity\User;

class CreateIncinerateurCommand extends Command
{
    /** @var UserRepository */
    private $userRepository;
    private $entityManager;

    public function __construct(
        UserRepository $repository,
        $entityManager
    ) {
        $this->userRepository = $repository;
        $this->entityManager = $entityManager;
        

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('aeris:create-incinerateur')
            ->setDescription('Loads the counter reports for a given user.')
            ->addArgument('name', InputArgument::REQUIRED, 'The number of lines.')
            ->addArgument('nb_lines', InputArgument::REQUIRED, 'The number of lines.')
            ->addArgument('nb_ovens', InputArgument::REQUIRED, 'The number of ovens per ligne.')
            ->addArgument('owner_username', InputArgument::REQUIRED, 'The user name of the owner.')
            ->addArgument('inspecteur_username', InputArgument::REQUIRED, 'The user name of the inspecteur.')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ownerUsername = $input->getArgument('owner_username');
        $inspecteurUsername = $input->getArgument('inspecteur_username');
        $name = $input->getArgument('name');

        if(empty($name)) {
            $output->writeln("Impossible to create the incinerateur.");
            $output->writeln("Incinerateur name is empty.");
        }

        if(!ctype_digit($input->getArgument('nb_lines')) || !ctype_digit($input->getArgument('nb_ovens'))) {
            $output->writeln("Impossible to create the incinerateur $name.");
            $output->writeln("The number of lines and number of ovens must be integers.");
            return;
        }

        $nbLignes = (int)($input->getArgument('nb_lines'));
        $nbFours = (int)($input->getArgument('nb_ovens'));

        $owner = $this->userRepository->findUserByUsername($ownerUsername);
        if($owner === null) {
            $output->writeln("Impossible to create the incinerateur $name.");
            $output->writeln(sprintf("User %s, provided for the owner, does not exist", $ownerUsername));
            return;   
        }

        $inspecteur = $this->userRepository->findUserByUsername($inspecteurUsername);
        if($inspecteur === null) {
            $output->writeln("Impossible to create the incinerateur $name.");
            $output->writeln(sprintf("The user %s, provided for the inspecteur, does not exist", $inspecteurUsername));
            return;   
        }

        $incinerateur = Incinerateur::create($name, $nbLignes, $nbFours, $owner, $inspecteur);

        $this->entityManager->persist($incinerateur);
        foreach ($incinerateur->getLignes() as $id => $line) {
            $this->entityManager->persist($line);
        }
        $this->entityManager->flush();
    }
}