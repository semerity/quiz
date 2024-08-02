<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    //    /**
    //     * @return Categorie[] Returns an array of Categorie objects
    //     */
    public function findAllCategorie(): array
    {
        $repository = $this->getEntityManager()->getRepository(Categorie::class);
        $all = $repository->findAll();
        return $all;
    }

    public function findOneCategorie($id)
    {
        $entityManager = $this->getEntityManager();

        $categorie = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Categorie p
            WHERE p.id in (:id)'
        )->setParameter('id', $id);

        return $categorie->getResult();
    }

    //    public function findOneBySomeField($value): ?Categorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
