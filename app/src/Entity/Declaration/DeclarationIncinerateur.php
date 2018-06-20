<?php

namespace App\Entity\Declaration;

use Doctrine\ORM\Mapping as ORM;

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
    const METHOD_DREAL = 'dreal';
    const METHOD_MEAC = 'meac300';
    const METHOD_WEX = 'wex';

    const STATUS_DRAFT = 'draft';
    const STATUS_VALIDATED = 'validated';

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
     * @ORM\Column(name="declaration_month", type="datetime", nullable=true)
     */
    private $declarationMonth;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Declaration\DeclarationDechets", mappedBy="declarationIncinerateur", cascade={"persist"})
     */
    private $declarationDechets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Declaration\DeclarationFonctionnementLigne", mappedBy="declarationIncinerateur", cascade={"persist"})
     */
    private $declarationsFonctionnementLigne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $methodeDeclaration;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     *
     * @var string
     */
    private $status;

    public function __construct(){
        $this->declarationsFonctionnementLigne = new ArrayCollection();
        $this->methodeDeclaration = self::METHOD_DREAL;
        $this->status = self::STATUS_DRAFT;
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
    public function getDeclarationsFonctionnementLigne()
    {
        return $this->declarationsFonctionnementLigne;
    }

    /**
     * @return mixed
     */
    public function setDeclarationsFonctionnementLigne($declarations)
    {
        $this->declarationsFonctionnementLigne = $declarations;
        return $this;
    }

    /**
     * @param mixed $declaration
     *
     * @return self
     */
    public function addDeclarationFonctionnementLigne($declaration)
    {
        $this->declarationsFonctionnementLigne[] = $declaration;
        $declaration->setDeclarationIncinerateur($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeclarationMonth()
    {
        return $this->declarationMonth;
    }

    /**
     * @param mixed $declarationMonth
     *
     * @return self
     */
    public function setDeclarationMonth($declarationMonth)
    {
        $this->declarationMonth = $declarationMonth;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodeDeclaration()
    {
        return $this->methodeDeclaration;
    }

    /**
     * @param string $methodeDeclaration
     *
     * @return self
     */
    public function setMethodeDeclaration($methodeDeclaration)
    {
        $this->methodeDeclaration = $methodeDeclaration;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
