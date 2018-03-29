<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneRepository")
 * @ORM\Table(name="incinerateur_ligne")
 */
class IncinerateurLigne
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
    public function getIncinerateur()
    {
        return $this->incinerateur;
    }

    /**
     * @param mixed $incinerateur
     *
     * @return self
     */
    public function setIncinerateur($incinerateur)
    {
        $this->incinerateur = $incinerateur;

        return $this;
    }

    /**
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param integer $numero
     *
     * @return self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return integer
     */
    public function getNbFours()
    {
        return $this->nbFours;
    }

    /**
     * @param integer $nbFours
     *
     * @return self
     */
    public function setNbFours($nbFours)
    {
        $this->nbFours = $nbFours;

        return $this;
    }
}
