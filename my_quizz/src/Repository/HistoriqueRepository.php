<?php

namespace App\Repository;

use App\Entity\Historique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Historique>
 */
class HistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historique::class);
    }

    public function getHistorique()
    {
        $repository = $this->getEntityManager()->getRepository(Historique::class);
        $historique = $repository->findAll();
        return $historique;
    }

    public function findLast(int $nb) {
        $entityManager = $this->getEntityManager();

        $lasts = $entityManager->createQuery(
            'SELECT p.nbBonneRep,p.nbQuestion,q.name,b.email
            FROM App\Entity\Historique p 
            JOIN App\Entity\Categorie q
            JOIN App\Entity\User b
            WHERE p.id_categorie = q.id AND p.id_user = b.id
            ORDER BY p.id DESC'
        );

        return $lasts->getResult();
    }
    //    /**
    //     * @return Historique[] Returns an array of Historique objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Historique
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
