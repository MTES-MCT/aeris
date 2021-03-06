<?php

namespace App\Repository;

use App\Entity\DeclarationFonctionnementLigne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DeclarationFonctionnementLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeclarationFonctionnementLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeclarationFonctionnementLigne[]    findAll()
 * @method DeclarationFonctionnementLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclarationFonctionnementLigneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DeclarationFonctionnementLigne::class);
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
