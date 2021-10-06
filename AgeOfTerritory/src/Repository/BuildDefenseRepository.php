<?php

namespace App\Repository;

use App\Entity\BuildDefense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BuildDefense|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildDefense|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildDefense[]    findAll()
 * @method BuildDefense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildDefenseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BuildDefense::class);
    }

    public function getAllDefensesByIsle($isle){
        return $this->createQueryBuilder('d')
            ->innerJoin('d.isle', 'isle')
            ->innerJoin('d.defense', 'def')
            ->andWhere('isle = :isle')
            ->setParameter('isle', $isle)
            ->getQuery()
            ->getResult();
    }

    public function getDefensesByNombreAndIsle($isle){
        return $this->createQueryBuilder('d')
            ->where('d.isle = :isle')
            ->andWhere('d.nombre >= :nombre')
            ->setParameter('isle', $isle)
            ->setParameter('nombre', 1)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return BuildDefense[] Returns an array of BuildDefense objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuildDefense
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
