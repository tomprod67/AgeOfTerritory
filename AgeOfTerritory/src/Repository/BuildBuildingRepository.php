<?php

namespace App\Repository;

use App\Entity\BuildBuilding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BuildBuilding|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildBuilding|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildBuilding[]    findAll()
 * @method BuildBuilding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildBuildingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BuildBuilding::class);
    }

    public function getAllBuildingsByIsle($isle){
        return $this->createQueryBuilder('b')
            ->innerJoin('b.isle', 'isle')
            ->innerJoin('b.building', 'bat')
            ->andWhere('isle = :isle')
            ->setParameter('isle', $isle)
            ->getQuery()
            ->getResult();
    }

    public function TenIsleWithUsername($longitude, $latitude){
        return $this->createQueryBuilder('i')
            ->Where('i.longitude = :longitude')
            ->andWhere('i.latitude = :latitude')
            ->setParameter('longitude', $longitude)
            ->setParameter('latitude', $latitude)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return BuildBuilding[] Returns an array of BuildBuilding objects
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
    public function findOneBySomeField($value): ?BuildBuilding
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
