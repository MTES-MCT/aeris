<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Aeris\Component\ReportParser\DataPoint;

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
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=10)
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

    public static function fromDataPoint(DataPoint $datapoint) {
        $mesure = new Mesure();
        $mesure->setDate($datapoint->date);
        $mesure->setType($datapoint->type);
        $mesure->setValue($datapoint->value);
        return $mesure;
    }

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

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
