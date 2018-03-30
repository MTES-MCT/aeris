<?php

namespace App\Entity\Declaration;

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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Declaration\DeclarationIncinerateur", inversedBy="declarationDechets", cascade={"persist"})
     */
    private $declarationIncinerateur;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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
     * @return mixed
     */
    public function getQtiteIncinereeTotale()
    {
        return $this->qtiteIncinereeTotale;
    }

    /**
     * @param mixed $qtiteIncinereeTotale
     *
     * @return self
     */
    public function setQtiteIncinereeTotale($qtiteIncinereeTotale)
    {
        $this->qtiteIncinereeTotale = $qtiteIncinereeTotale;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtiteIncinereeDechetsDangereux()
    {
        return $this->qtiteIncinereeDechetsDangereux;
    }

    /**
     * @param mixed $qtiteIncinereeDechetsDangereux
     *
     * @return self
     */
    public function setQtiteIncinereeDechetsDangereux($qtiteIncinereeDechetsDangereux)
    {
        $this->qtiteIncinereeDechetsDangereux = $qtiteIncinereeDechetsDangereux;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtiteIncinereeDechetsDasri()
    {
        return $this->qtiteIncinereeDechetsDasri;
    }

    /**
     * @param mixed $qtiteIncinereeDechetsDasri
     *
     * @return self
     */
    public function setQtiteIncinereeDechetsDasri($qtiteIncinereeDechetsDasri)
    {
        $this->qtiteIncinereeDechetsDasri = $qtiteIncinereeDechetsDasri;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtiteIncinereeDechetsNonDangereux()
    {
        return $this->qtiteIncinereeDechetsNonDangereux;
    }

    /**
     * @param mixed $qtiteIncinereeDechetsNonDangereux
     *
     * @return self
     */
    public function setQtiteIncinereeDechetsNonDangereux($qtiteIncinereeDechetsNonDangereux)
    {
        $this->qtiteIncinereeDechetsNonDangereux = $qtiteIncinereeDechetsNonDangereux;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtiteIncinereeDechetsNonDangereuxMenagers()
    {
        return $this->qtiteIncinereeDechetsNonDangereuxMenagers;
    }

    /**
     * @param mixed $qtiteIncinereeDechetsNonDangereuxMenagers
     *
     * @return self
     */
    public function setQtiteIncinereeDechetsNonDangereuxMenagers($qtiteIncinereeDechetsNonDangereuxMenagers)
    {
        $this->qtiteIncinereeDechetsNonDangereuxMenagers = $qtiteIncinereeDechetsNonDangereuxMenagers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtiteIncinereeDechetsNonDangereuxRefusTri()
    {
        return $this->qtiteIncinereeDechetsNonDangereuxRefusTri;
    }

    /**
     * @param mixed $qtiteIncinereeDechetsNonDangereuxRefusTri
     *
     * @return self
     */
    public function setQtiteIncinereeDechetsNonDangereuxRefusTri($qtiteIncinereeDechetsNonDangereuxRefusTri)
    {
        $this->qtiteIncinereeDechetsNonDangereuxRefusTri = $qtiteIncinereeDechetsNonDangereuxRefusTri;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtiteIncinereeDechetsNonDangereuxDae()
    {
        return $this->qtiteIncinereeDechetsNonDangereuxDae;
    }

    /**
     * @param mixed $qtiteIncinereeDechetsNonDangereuxDae
     *
     * @return self
     */
    public function setQtiteIncinereeDechetsNonDangereuxDae($qtiteIncinereeDechetsNonDangereuxDae)
    {
        $this->qtiteIncinereeDechetsNonDangereuxDae = $qtiteIncinereeDechetsNonDangereuxDae;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeclarationIncinerateur()
    {
        return $this->declarationIncinerateur;
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
}
