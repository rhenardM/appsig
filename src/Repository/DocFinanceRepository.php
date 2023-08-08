<?php

namespace App\Repository;

use App\Entity\DocFinance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocFinance>
 *
 * @method DocFinance|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocFinance|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocFinance[]    findAll()
 * @method DocFinance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocFinanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocFinance::class);
    }

//    /**
//     * @return DocFinance[] Returns an array of DocFinance objects
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

//    public function findOneBySomeField($value): ?DocFinance
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
