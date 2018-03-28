<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeclarationIncinerateurRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class DeclarationIncinerateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="creationDate", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Incinerateur", inversedBy="declarationsIncinerateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $incinerateur;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
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
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     *
     * @return self
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

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
}
