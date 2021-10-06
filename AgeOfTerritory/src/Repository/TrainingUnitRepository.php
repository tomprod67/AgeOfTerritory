<?php

namespace App\Repository;

use App\Entity\TrainingUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingUnit[]    findAll()
 * @method TrainingUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingUnitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingUnit::class);
    }

    public function getAllUnitsByIsle($isle){
        return $this->createQueryBuilder('u')
            ->innerJoin('u.isle', 'isle')
            ->innerJoin('u.unit', 'unit')
            ->andWhere('isle = :isle')
            ->setParameter('isle', $isle)
            ->getQuery()
            ->getResult();
    }

    public function CheckUnitForSpyOnIsle($isle)
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.isle', 'i')
            ->innerJoin('u.unit', 'unit')
            ->where('i = :isle')
            ->andWhere('unit.id = :id_archeologue')
            ->andWhere('u.nombre >= :nombre')
            ->setParameter('id_archeologue', 9)
            ->setParameter('nombre', 1)
            ->setParameter('isle', $isle)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getUnitsByNombreAndIsle($isle){
        return $this->createQueryBuilder('u')
            ->where('u.isle = :isle')
            ->andWhere('u.nombre >= :nombre')
            ->setParameter('isle', $isle)
            ->setParameter('nombre', 1)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return TrainingUnit[] Returns an array of TrainingUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrainingUnit
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
