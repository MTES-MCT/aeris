<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Declaration\DeclarationIncinerateur;
/**
 * @ORM\Entity(repositoryClass="App\Repository\IncinerateurRepository")
 * @ORM\Table(name="incinerateur")
 */
class Incinerateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $nbLignes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="incinerateurs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Declaration\DeclarationIncinerateur", mappedBy="incinerateur")
     */
    private $declarationsIncinerateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Declaration\DeclarationDioxine", mappedBy="incinerateur")
     */
    private $declarationsDioxine;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IncinerateurLigne", mappedBy="incinerateur")
     */
    private $lignes;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getNbLignes()
    {
        return $this->nbLignes;
    }

    /**
     * @param int $nbLignes
     *
     * @return self
     */
    public function setNbLignes($nbLignes)
    {
        $this->nbLignes = $nbLignes;

        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDeclarationsIncinerateur()
    {
        return $this->declarationsIncinerateur;
    }

    /**
     * @return mixed
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * @param mixed $lignes
     *
     * @return self
     */
    public function setLignes($lignes)
    {
        $this->lignes = $lignes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeclarationsDioxine()
    {
        return $this->declarationsDioxine;
    }

    /**
     * @param mixed $declarationsDioxine
     *
     * @return self
     */
    public function setDeclarationsDioxine($declarationsDioxine)
    {
        $this->declarationsDioxine = $declarationsDioxine;

        return $this;
    }
}
