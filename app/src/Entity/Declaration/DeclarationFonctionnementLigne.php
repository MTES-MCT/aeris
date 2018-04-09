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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Declaration\DeclarationIncinerateur", inversedBy="declarationsFonctionnementLigne")
     * @ORM\JoinColumn(nullable=true)
     */
    private $declarationIncinerateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IncinerateurLigne", inversedBy="declarationsFonctionnement")
     */
    private $ligne;

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $nbHeuresFonctionnementTh
     *
     * @return self
     */
    public function setNbHeuresFonctionnementTh($nbHeuresFonctionnementTh)
    {
        $this->nbHeuresFonctionnementTh = $nbHeuresFonctionnementTh;

        return $this;
    }

    /**
     * @param mixed $nbHeuresFonctionnementReel
     *
     * @return self
     */
    public function setNbHeuresFonctionnementReel($nbHeuresFonctionnementReel)
    {
        $this->nbHeuresFonctionnementReel = $nbHeuresFonctionnementReel;

        return $this;
    }

    /**
     * @param mixed $declarationIncinerateur
     *
     * @return self
     */
    public function setDeclarationIncinerateur($declarationIncinerateur)
    {
        $this->declarationIncinerateur = $declarationIncinerateur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLigne()
    {
        return $this->ligne;
    }

    /**
     * @param mixed $ligne
     *
     * @return self
     */
    public function setLigne($ligne)
    {
        $this->ligne = $ligne;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNbHeuresFonctionnementTh()
    {
        return $this->nbHeuresFonctionnementTh;
    }

    /**
     * @return mixed
     */
    public function getNbHeuresFonctionnementReel()
    {
        return $this->nbHeuresFonctionnementReel;
    }

    /**
     * @return mixed
     */
    public function getDeclarationIncinerateur()
    {
        return $this->declarationIncinerateur;
    }
}
