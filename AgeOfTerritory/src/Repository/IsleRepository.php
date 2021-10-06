<?php

namespace App\Repository;

use App\Entity\Isle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Isle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Isle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Isle[]    findAll()
 * @method Isle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Isle::class);
    }

    // Requete qui sert a recuperer les longitude et latitude passer en parametre et de les afficher
    // Utiliser dans la navigation de la map (Ocean)
    public function TenIsleWithUsername($longitude, $latitude)
    {
        return $this->createQueryBuilder('i')
            ->Where('i.longitude = :longitude')
            ->andWhere('i.latitude = :latitude')
            ->setParameter('longitude', $longitude)
            ->setParameter('latitude', $latitude)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // Requete qui sert a recuperer le total de point des ile de chaque joueur
    // Utiliser pour le ranking (classement)

    public function getUserByPowerPointOfTotalIsle()
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.user', 'u')
            ->Where('i.user = u.id')
            ->addSelect('u.username')
            ->addSelect('SUM(i.powerPoint) AS nbPoint')
            ->groupBy('u.username')
            ->orderBy('nbPoint', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getIsleByCoordinate($longitude_cible, $latitude_cible, $position_cible)
    {
        return $this->createQueryBuilder('i')
            ->Where('i.longitude = :longitude')
            ->andWhere('i.latitude = :latitude')
            ->andWhere('i.position = :position')
            ->setParameter('longitude', $longitude_cible)
            ->setParameter('latitude', $latitude_cible)
            ->setParameter('position', $position_cible)
            ->getQuery()
            ->getOneOrNullResult();
    }



    /*
    *@return Isle[] Returns an array of Isle objects
    /

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /*
    public function findOneBySomeField($value): ?Isle
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
