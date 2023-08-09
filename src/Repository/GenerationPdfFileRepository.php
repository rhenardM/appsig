<?php

namespace App\Repository;

use App\Entity\GenerationPdfFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GenerationPdfFile>
 *
 * @method GenerationPdfFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenerationPdfFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenerationPdfFile[]    findAll()
 * @method GenerationPdfFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenerationPdfFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenerationPdfFile::class);
    }

//    /**
//     * @return GenerationPdfFile[] Returns an array of GenerationPdfFile objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GenerationPdfFile
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
