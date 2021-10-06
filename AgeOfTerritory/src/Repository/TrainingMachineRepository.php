<?php

namespace App\Repository;

use App\Entity\TrainingMachine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingMachine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingMachine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingMachine[]    findAll()
 * @method TrainingMachine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingMachineRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingMachine::class);
    }

    public function getAllMachinesByIsle($isle){
        return $this->createQueryBuilder('m')
            ->innerJoin('m.isle', 'isle')
            ->innerJoin('m.machine', 'mach')
            ->andWhere('isle = :isle')
            ->setParameter('isle', $isle)
            ->getQuery()
            ->getResult();
    }

    public function getMachinesByNombreAndIsle($isle){
        return $this->createQueryBuilder('m')
            ->where('m.isle = :isle')
            ->andWhere('m.nombre >= :nombre')
            ->setParameter('isle', $isle)
            ->setParameter('nombre', 1)
            ->getQuery()
            ->getResult();
    }

    public function CheckMachineForSpyOnIsle($isle)
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.isle', 'i')
            ->innerJoin('m.machine', 'mach')
            ->where('i = :isle')
            ->andWhere('mach.id = :id_droneEspion')
            ->andWhere('m.nombre >= :nombre')
            ->setParameter('isle', $isle)
            ->setParameter('id_droneEspion', 6)
            ->setParameter('nombre', 1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return TrainingMachine[] Returns an array of TrainingMachine objects
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
    public function findOneBySomeField($value): ?TrainingMachine
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
