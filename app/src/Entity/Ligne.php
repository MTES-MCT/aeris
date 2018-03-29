<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneRepository")
 */
class Ligne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Incinerateur", inversedBy="lignes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $incinerateur;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $nbFours;
}
