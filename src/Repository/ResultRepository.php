<?php

namespace App\Repository;

use App\Entity\Result;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Result>
 *
 * @method Result|null find($id, $lockMode = null, $lockVersion = null)
 * @method Result|null findOneBy(array $criteria, array $orderBy = null)
 * @method Result[]    findAll()
 * @method Result[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Result::class);
    }

    public function add(Result $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Result $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Result[] Returns an array of Result objects
     */

    public function menGeneral() 
    {
        $query = $this->createQueryBuilder('result')
            ->select('competitor.firstname, competitor.lastname, competitor.city, category.category_name, result.final_result')
            ->join('result.competitor', 'competitor')
            ->join('result.category', 'category')
            ->join('result.competition', 'competition')        
            ->andWhere('category.category_name = :category_name')
            ->setParameter('category_name', "Générales hommes")
            ->orderBy('result.final_result', 'ASC');
        
        return $query->getQuery()->getResult();
    }

    /**
     * @return Result[] Returns an array of Result objects
     */

    public function womenGeneral() 
    {
        $query = $this->createQueryBuilder('result')
            ->select('competitor.firstname, competitor.lastname, competitor.city, category.category_name, result.final_result')
            ->join('result.competitor', 'competitor')
            ->join('result.category', 'category')
            ->join('result.competition', 'competition')        
            ->andWhere('category.category_name = :category_name')
            ->setParameter('category_name', "Générales femmes")
            ->orderBy('result.final_result', 'ASC');
        
        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Result[] Returns an array of Result objects
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

//    public function findOneBySomeField($value): ?Result
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
