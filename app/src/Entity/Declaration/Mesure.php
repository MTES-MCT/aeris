<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesureRepository")
 */
class Mesure
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IncinerateurLigne", inversedBy="mesuresDioxine")
     */
    private $ligne;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=0, scale=0)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $value;

    /**
     * @ORM\Column(type="string", nullable=false, length=32)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Declaration\DeclarationFonctionnementLigne", inversedBy="mesures")
     * @ORM\JoinColumn(nullable=true)
     */
    private $declarationFonctionnementLigne;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return self
     */
    public function setDate($dateDebut)
    {
        $this->date = $date;

        return $this;
    }

}
