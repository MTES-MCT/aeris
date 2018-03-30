<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeclarationDechetsRepository")
 */
class DeclarationDechets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeTotale;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeDechetsDangereux;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeDechetsDasri;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeDechetsNonDangereux;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeDechetsNonDangereuxMenagers;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeDechetsNonDangereuxRefusTri;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $qtiteIncinereeDechetsNonDangereuxDae;    
}
