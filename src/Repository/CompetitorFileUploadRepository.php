<?php

namespace App\Repository;

use App\Entity\CompetitorFileUpload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetitorFileUpload>
 *
 * @method CompetitorFileUpload|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitorFileUpload|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitorFileUpload[]    findAll()
 * @method CompetitorFileUpload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitorFileUploadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetitorFileUpload::class);
    }

    public function add(CompetitorFileUpload $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CompetitorFileUpload $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CompetitorFileUpload[] Returns an array of CompetitorFileUpload objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompetitorFileUpload
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
