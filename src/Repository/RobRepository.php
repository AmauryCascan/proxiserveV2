<?php

namespace App\Repository;

use App\Entity\Rob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rob>
 *
 * @method Rob|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rob|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rob[]    findAll()
 * @method Rob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rob::class);
    }

//    /**
//     * @return Rob[] Returns an array of Rob objects
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

//    public function findOneBySomeField($value): ?Rob
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
