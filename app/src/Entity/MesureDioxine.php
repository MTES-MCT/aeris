<?php

namespace App\Entity;

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
}
