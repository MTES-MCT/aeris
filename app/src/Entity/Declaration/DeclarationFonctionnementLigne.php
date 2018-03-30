<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeclarationFonctionnementLigneRepository")
 */
class DeclarationFonctionnementLigne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal")
     */
    private $nbHeuresFonctionnementTh;
    
    /**
     * @ORM\Column(type="decimal")
     */
    private $nbHeuresFonctionnementReel;
}
