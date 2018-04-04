<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesureDioxineRepository")
 */
class MesureDioxine
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
    private $numeroLigne;

    /**
     * @ORM\Column(name="dateDebut", type="date", nullable=false)
     */
    private $dateDebut;
    
    /**
     * @ORM\Column(name="dateFin", type="date", nullable=false)
     */
    private $dateFin;
    
    /**
     * @ORM\Column(type="decimal")
     */
    private $disponibiliteLigne; 
    
    /**
     * @ORM\Column(type="decimal")
     */
    private $disponibiliteAnalyseur;
    
    /**
     * @ORM\Column(type="text")
     */
    private $nomLaboratoire;

    /**
     * @ORM\Column(type="decimal")
     */
    private $concentration;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Declaration\DeclarationIncinerateur", inversedBy="mesuresDioxine")
     * @ORM\JoinColumn(nullable=true)
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
    public function getNumeroLigne()
    {
        return $this->numeroLigne;
    }

    /**
     * @param mixed $numeroLigne
     *
     * @return self
     */
    public function setNumeroLigne($numeroLigne)
    {
        $this->numeroLigne = $numeroLigne;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     *
     * @return self
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     *
     * @return self
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisponibiliteLigne()
    {
        return $this->disponibiliteLigne;
    }

    /**
     * @param mixed $disponibiliteLigne
     *
     * @return self
     */
    public function setDisponibiliteLigne($disponibiliteLigne)
    {
        $this->disponibiliteLigne = $disponibiliteLigne;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisponibiliteAnalyseur()
    {
        return $this->disponibiliteAnalyseur;
    }

    /**
     * @param mixed $disponibiliteAnalyseur
     *
     * @return self
     */
    public function setDisponibiliteAnalyseur($disponibiliteAnalyseur)
    {
        $this->disponibiliteAnalyseur = $disponibiliteAnalyseur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomLaboratoire()
    {
        return $this->nomLaboratoire;
    }

    /**
     * @param mixed $nomLaboratoire
     *
     * @return self
     */
    public function setNomLaboratoire($nomLaboratoire)
    {
        $this->nomLaboratoire = $nomLaboratoire;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConcentration()
    {
        return $this->concentration;
    }

    /**
     * @param mixed $concentration
     *
     * @return self
     */
    public function setConcentration($concentration)
    {
        $this->concentration = $concentration;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param mixed $commentaire
     *
     * @return self
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

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
