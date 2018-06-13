<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\UserRepository;
use Aeris\Component\ReportParser\DeclarationImporter;

use App\Entity\IncinerateurLigne;
use App\Entity\Incinerateur;
use App\Entity\User;

class CreerIncinerateurCommand extends Command
{
    /** @var IncinerateurRepository */
    private $repository;
    private $em;

    public function __construct(
        UserRepository $repository
        IncinerateurRepository $repository
    ) {
        $this->userRepository = $repository;
        

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('aeris:creer-incinerateur')
            ->setDescription('Loads the counter reports for a given user.')
            ->addArgument('name', InputArgument::REQUIRED, 'The number of lines.')
            ->addArgument('nb_lignes', InputArgument::REQUIRED, 'The number of lines.')
            ->addArgument('nb_fours', InputArgument::REQUIRED, 'The number of ovens per ligne.')
            ->addArgument('owner_id', InputArgument::REQUIRED, 'The user id of the owner.')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ownerId = $input->getArgument('owner_id');
        $nbLignes = $input->getArgument('nb_lignes');
        $nbFours = $input->getArgument('nb_lignes');
        
        $owner = $this->userRepository
            ->find($ownerId);

        $incinerateur = new Incinerateur();
        $incinerateur->setOwner($owner);

        for($i = 0; $i < $nbLignes; ++$i) {
            $ligne = new IncinerateurLigne();
            $ligne->setFours($nbFours);
            $ligne->setIncinerateur($incinerateur);
        }

        // $this->em->persist($incinerateur);
        // $this->em->flush();
    }    
}