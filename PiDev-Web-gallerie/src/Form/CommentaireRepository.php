<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
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
    public function findOneBySomeField($value): ?Commentaire
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function myComments($idu,$phs){
        return $this->createQueryBuilder('c')
            ->andWhere('c.idu=:idu')
            ->andWhere('c.idPhoto=:phs')
            ->setParameter('idu',$idu)
            ->setParameter('phs', $phs)
            ->getQuery()
            ->getResult();
    }
    public function allComments($utils,$phs){
        $query = $this->getEntityManager()
            ->createQuery('SELECT c FROM \App\Entity\Commentaire c WHERE  c.idu!=:utils AND  c.idPhoto=:phs')
            ->setParameter('utils', $utils)
            ->setParameter('phs', $phs);
        return $query->getResult();
    }

    public function backComments($id){
        return $this->createQueryBuilder('c')
            ->andWhere('c.idPhoto=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
