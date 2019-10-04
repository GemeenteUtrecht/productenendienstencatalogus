<?php

namespace App\Repository;

use App\Entity\Catalogus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Catalogus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalogus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalogus[]    findAll()
 * @method Catalogus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalogus::class);
    }

    // /**
    //  * @return Catalogus[] Returns an array of Catalogus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Catalogus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
