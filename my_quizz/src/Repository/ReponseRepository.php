<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reponse>
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    public function findReponse($id)
    {
        // $entityManager = $this->getEntityManager();

        return $this->createQueryBuilder('u')
        ->where("u.id_question IN(:id)")
        ->setParameter('id', array_values($id))
        ->getQuery()
        ->getResult()
    ;

        // returns an array of Product objects
        // return $reponses->getResult();
    }

    public function findOneReponse($id)
    {
        return $this->createQueryBuilder('u')
        ->where("u.id = :id")
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult()
        ;
    }

    //    /**
    //     * @return Reponse[] Returns an array of Reponse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reponse
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
