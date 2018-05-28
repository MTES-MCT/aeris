<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Aeris\Component\ReportParser\DataPoint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesureCompteurRepository")
 */
class MesureCompteur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $value;

    /**
     * @ORM\Column(type="string", nullable=false, length=32)
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=false, length=32)
     */
    private $component;

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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeclarationFonctionnementLigne()
    {
        return $this->declarationFonctionnementLigne;
    }

    /**
     * @param mixed $declarationFonctionnementLigne
     *
     * @return self
     */
    public function setDeclarationFonctionnementLigne($declarationFonctionnementLigne)
    {
        $this->declarationFonctionnementLigne = $declarationFonctionnementLigne;

        return $this;
    }
}
