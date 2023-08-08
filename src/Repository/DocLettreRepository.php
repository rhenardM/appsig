<?php

namespace App\Repository;

use App\Entity\DocLettre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocLettre>
 *
 * @method DocLettre|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocLettre|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocLettre[]    findAll()
 * @method DocLettre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocLettreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocLettre::class);
    }

//    /**
//     * @return DocLettre[] Returns an array of DocLettre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DocLettre
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
