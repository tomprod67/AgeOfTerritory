<?php

namespace App\Repository;

use App\Entity\SearchTechnology;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SearchTechnology|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchTechnology|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchTechnology[]    findAll()
 * @method SearchTechnology[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchTechnologyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SearchTechnology::class);
    }

    public function getAllTechnologiesByIsle($isle){

        return $this->createQueryBuilder('s')
            ->innerJoin('s.isle', 'isle')
            ->innerJoin('s.technology', 'technology')
            ->andWhere('isle = :isle')
            ->setParameter('isle', $isle)
            ->getQuery()
            ->getResult();
    }

    public function getTechnologyAndLevelByIsle($isle, $technology){

        return $this->createQueryBuilder('s')
            ->innerJoin('s.isle', 'isle')
            ->innerJoin('s.technology', 'technology')
            ->andWhere('isle = :isle')
            ->andWhere('technology = :technology')
            ->setParameter('isle', $isle)
            ->setParameter('technology', $technology)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return SearchTechnology[] Returns an array of SearchTechnology objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchTechnology
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
