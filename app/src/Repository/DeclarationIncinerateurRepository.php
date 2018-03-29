<?php

namespace App\Repository;

use App\Entity\DeclarationIncinerateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DeclarationIncinerateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeclarationIncinerateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeclarationIncinerateur[]    findAll()
 * @method DeclarationIncinerateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarationIncinerateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DeclarationIncinerateur::class);
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
