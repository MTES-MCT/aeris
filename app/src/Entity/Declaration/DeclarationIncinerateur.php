<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Incinerateur;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeclarationIncinerateurRepository")
 * @ORM\HasLifecycleCallbacks()
* @ORM\Table(name="declaration_incinerateur")
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
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Incinerateur", inversedBy="declarationsIncinerateur")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $declarationFileName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="declaration_incinerateur", fileNameProperty="declarationFileName")
     * 
     * @var File
     */
    private $declarationFile;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Declaration\DeclarationDechets", mappedBy="declarationIncinerateur", cascade={"persist"})
     */
    private $declarationDechets;
 
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Declaration\MesureDioxine", mappedBy="declarationIncinerateur", cascade={"persist"})
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
     * @return string
     */
    public function getDeclarationFileName()
    {
        return $this->declarationFileName;
    }

    /**
     * @param string $declarationFileName
     *
     * @return self
     */
    public function setDeclarationFileName($declarationFileName)
    {
        $this->declarationFileName = $declarationFileName;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setDeclarationFile(?File $declarationFile = null): void
    {
        $this->imageFile = $declarationFile;
    }

    public function getDeclarationFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return mixed
     */
    public function getDeclarationDechets()
    {
        return $this->declarationDechets;
    }

    /**
     * @param mixed $declarationDechets
     *
     * @return self
     */
    public function setDeclarationDechets($declarationDechets)
    {
        $this->declarationDechets = $declarationDechets;
        $this->declarationDechets->setDeclarationIncinerateur($this);

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
        $mesureDioxine->setDeclarationIncinerateur($this);
        return $this;
    }
}
