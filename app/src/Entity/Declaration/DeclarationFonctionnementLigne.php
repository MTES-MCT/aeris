<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeclarationFonctionnementLigneRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $declarationCompteursFileName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="declaration_incinerateur", fileNameProperty="declarationCompteursFileName")
     * 
     * @var File
     */
    private $declarationCompteursFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $declarationFluxFileName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="declaration_incinerateur", fileNameProperty="declarationFluxFileName")
     * 
     * @var File
     */
    private $declarationFluxFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $declarationConcentrationsFileName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="declaration_incinerateur", fileNameProperty="declarationConcentrationsFileName")
     * 
     * @var File
     */
    private $declarationConcentrationsFile;

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

    /**
     * @return File
     */
    public function getDeclarationConcentrationsFile()
    {
        return $this->declarationConcentrationsFile;
    }

    /**
     * @param File $declarationConcentrationsFile
     *
     * @return self
     */
    public function setDeclarationConcentrationsFile(File $declarationConcentrationsFile)
    {
        $this->declarationConcentrationsFile = $declarationConcentrationsFile;

        return $this;
    }

    /**
     * @return File
     */
    public function getDeclarationFluxFile()
    {
        return $this->declarationFluxFile;
    }

    /**
     * @param File $declarationFluxFile
     *
     * @return self
     */
    public function setDeclarationFluxFile(File $declarationFluxFile)
    {
        $this->declarationFluxFile = $declarationFluxFile;

        return $this;
    }

    /**
     * @return File
     */
    public function getDeclarationCompteursFile()
    {
        return $this->declarationCompteursFile;
    }

    /**
     * @param File $declarationCompteursFile
     *
     * @return self
     */
    public function setDeclarationCompteursFile(File $declarationCompteursFile)
    {
        $this->declarationCompteursFile = $declarationCompteursFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeclarationFluxFileName()
    {
        return $this->declarationFluxFileName;
    }

    /**
     * @param string $declarationFluxFileName
     *
     * @return self
     */
    public function setDeclarationFluxFileName($declarationFluxFileName)
    {
        $this->declarationFluxFileName = $declarationFluxFileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeclarationCompteursFileName()
    {
        return $this->declarationCompteursFileName;
    }

    /**
     * @param string $declarationCompteursFileName
     *
     * @return self
     */
    public function setDeclarationCompteursFileName($declarationCompteursFileName)
    {
        $this->declarationCompteursFileName = $declarationCompteursFileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeclarationConcentrationsFileName()
    {
        return $this->declarationConcentrationsFileName;
    }

    /**
     * @param string $declarationConcentrationsFileName
     *
     * @return self
     */
    public function setDeclarationConcentrationsFileName($declarationConcentrationsFileName)
    {
        $this->declarationConcentrationsFileName = $declarationConcentrationsFileName;

        return $this;
    }
}
