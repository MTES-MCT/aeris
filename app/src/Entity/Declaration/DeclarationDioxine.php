<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Incinerateur;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeclarationDioxineRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="declaration_dioxines")
 * @Vich\Uploadable
 */
class DeclarationDioxine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Incinerateur", inversedBy="declarationsDioxine")
     * @ORM\JoinColumn(nullable=true)
     */
    private $incinerateur;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $comment;
 
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Declaration\MesureDioxine", mappedBy="declarationDioxine", cascade={"persist"})
     */
    private $mesuresDioxine;

    public function __construct(){
        $this->mesuresDioxine = new ArrayCollection();
    }

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
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMesuresDioxine()
    {
        return $this->mesuresDioxine;
    }

    /**
     * @return mixed
     */
    public function setMesuresDioxine($mesures)
    {
        $this->mesuresDioxine = $mesures;
        return $this;
    }

    /**
     * @param mixed $mesuresDioxine
     *
     * @return self
     */
    public function addMesuresDioxines($mesureDioxine)
    {
        $this->mesuresDioxine[] = $mesureDioxine;
        $mesureDioxine->setDeclarationDioxine($this);
        return $this;
    }
}
