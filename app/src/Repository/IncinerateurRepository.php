<?php

namespace App\Repository;

use App\Entity\Incinerateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Incinerateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incinerateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incinerateur[]    findAll()
 * @method Incinerateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncinerateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incinerateur::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('i')
            ->where('i.something = :value')->setParameter('value', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
