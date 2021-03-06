<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Incinerateur;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Incinerateur", mappedBy="owner")
     */
    private $incinerateurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Incinerateur", mappedBy="inspecteur")
     */
    private $incinerateursToWatch;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return []Incinerateur
     */
    public function getIncinerateurs()
    {
        return $this->incinerateurs;
    }
}