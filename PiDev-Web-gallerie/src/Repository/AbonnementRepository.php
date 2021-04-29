<?php

namespace App\Repository;

use App\Entity\Abonnement2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Abonnement2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnement2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnement2[]    findAll()
 * @method Abonnement2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonnement2::class);
    }

    // /**
    //  * @return Abonnement[] Returns an array of Abonnement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Abonnement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function delabns($idu){
        return $this->createQueryBuilder('a')
            ->andWhere('a.idu=:idu')
            ->setParameter('idu',$idu)
            ->getQuery()
            ->getSingleResult();
    }
}
