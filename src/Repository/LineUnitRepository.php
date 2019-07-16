<?php

namespace App\Repository;

use App\Entity\LineUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LineUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineUnit[]    findAll()
 * @method LineUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineUnitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LineUnit::class);
    }

    // /**
    //  * @return LineUnit[] Returns an array of LineUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LineUnit
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
