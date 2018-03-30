<?php

namespace App\Repository;

use App\Entity\DeclarationDechets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DeclarationDechets|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeclarationDechets|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeclarationDechets[]    findAll()
 * @method DeclarationDechets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarationDechetsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DeclarationDechets::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('d')
            ->where('d.something = :value')->setParameter('value', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
