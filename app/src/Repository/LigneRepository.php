<?php

namespace App\Repository;

use App\Entity\Ligne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ligne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ligne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ligne[]    findAll()
 * @method Ligne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ligne::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('l')
            ->where('l.something = :value')->setParameter('value', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
