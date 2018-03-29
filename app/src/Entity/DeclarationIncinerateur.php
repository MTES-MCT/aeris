<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

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
}
