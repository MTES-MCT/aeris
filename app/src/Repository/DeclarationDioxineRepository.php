<?php

namespace App\Repository;

use App\Entity\Declaration\DeclarationDioxine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DeclarationDioxine|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeclarationDioxine|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeclarationDioxine[]    findAll()
 * @method DeclarationDioxine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarationDioxineRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DeclarationDioxine::class);
    }

    public function findValidatedDeclarations($incinerateur)
    {
        return $this->createQueryBuilder('d')
            ->where('d.incinerateur = :incinerateur')
            ->andWhere('d.status = :status')
            ->setParameter('incinerateur', $incinerateur)
            ->setParameter('status', DeclarationDioxine::STATUS_VALIDATED)
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
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
