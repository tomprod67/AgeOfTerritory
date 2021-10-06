<?php

namespace App\Repository;

use App\Entity\Evolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evolution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evolution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evolution[]    findAll()
 * @method Evolution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvolutionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evolution::class);
    }

    // /**
    //  * @return Evolution[] Returns an array of Evolution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evolution
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
