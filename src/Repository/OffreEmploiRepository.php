<?php

namespace App\Repository;

use App\Entity\OffreEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OffreEmploi>
 */
class OffreEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreEmploi::class);
    }

    // public function findLatest(int $limit = 10): array
    // {
    //     return $this->createQueryBuilder('o')
    //         ->orderBy('o.id', 'DESC')
    //         ->setMaxResults($limit)
    //         ->getQuery()
    //         ->getResult();
    // }

 /**
     * @return OffreWithCountDTO[]
     */
    public function findAllWithDetails(int $limit = 10): array
    {
        return $this->createQueryBuilder('o')
            ->select('NEW App\\DTO\\OffreWithCountDTO(o.id, o.titre, o.salaire, o.created_at, o.description,o.reference, c.nom,c.slug)')
            ->leftJoin('o.categorie', 'c')
            ->orderBy('o.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return OffreWithCountDTO[]
     */

    public function findAllJobs(): array
    {
        return $this->createQueryBuilder('o')
            ->select('NEW App\\DTO\\OffreWithCountDTO( o.id,o.titre, o.salaire, o.created_at, o.description,o.reference, c.nom,c.slug)')
            ->leftJoin('o.categorie', 'c')
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    


    //    /**
    //     * @return OffreEmploi[] Returns an array of OffreEmploi objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OffreEmploi
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
