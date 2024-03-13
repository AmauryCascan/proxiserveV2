<?php

namespace App\Repository;

use App\Entity\Travaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Travaux>
 *
 * @method Travaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travaux[]    findAll()
 * @method Travaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travaux::class);
    }

        /**
         * @return Travaux[] Returns an array of Travaux objects
         */
        public function findAllEnCours($values): array
        {
            return $this->createQueryBuilder('t')
                ->leftJoin('t.type', 'y')
                ->leftJoin('t.secteur', 's')
                ->leftJoin('t.etat', 'e')
                ->leftJoin('t.comments','c')
                ->leftJoin('t.user','u')
                ->addSelect('y')
                ->addSelect('s')
                ->addSelect('e')
                ->addSelect('u')
                ->andWhere('e.name NOT IN (:values)')
                ->setParameter('values', $values)
                ->orderBy('t.finished_at', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        /**
         * @return Travaux[] Returns an array of Travaux objects
         */
        public function findAllAnnule($value): array
        {
            return $this->createQueryBuilder('t')
                ->leftJoin('t.type', 'y')
                ->leftJoin('t.secteur', 's')
                ->leftJoin('t.etat', 'e')
                ->leftJoin('t.comments','c')
                ->leftJoin('t.user','u')
                ->addSelect('y')
                ->addSelect('s')
                ->addSelect('e')
                ->addSelect('u')
                ->andWhere('e.name = :val')
                ->setParameter('val', $value)
                ->orderBy('t.finished_at', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }
        /**
         * @return Travaux[] Returns an array of Travaux objects
         */
        public function findAllwithFacture($value1, $value2): array
        {
            return $this->createQueryBuilder('t')
                ->leftJoin('t.type', 'y')
                ->leftJoin('t.secteur', 's')
                ->leftJoin('t.etat', 'e')
                ->leftJoin('t.comments','c')
                ->leftJoin('t.user','u')
                ->addSelect('y')
                ->addSelect('s')
                ->addSelect('e')
                ->addSelect('u')
                ->andWhere('e.name = :val1 OR e.name = :val2')
                ->setParameter('val1', $value1)
                ->setParameter('val2', $value2)
                ->orderBy('t.finished_at', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        /**
         * @return Travaux[] Returns an array of Travaux objects
         */
        public function findWithRobs(): array
        {
            return $this->createQueryBuilder('t')
                ->innerJoin('t.type', 'y')
                ->innerJoin('t.secteur', 's')
                ->innerJoin('t.etat', 'e')
                ->innerJoin('t.robs', 'r')
                ->innerJoin('t.user', 'u')
                ->addSelect('y')
                ->addSelect('s')
                ->addSelect('e')
                ->addSelect('r')
                ->addSelect('u')
                ->orderBy('t.finished_at', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        public function findOneBySomeField($value): ?Travaux
        {
            return $this->createQueryBuilder('t')
                ->leftJoin('t.type', 'y')
                ->leftJoin('t.secteur', 's')
                ->leftJoin('t.etat', 'e')
                ->leftJoin('t.user', 'u')
                ->addSelect('y')
                ->addSelect('s')
                ->addSelect('e')
                ->addSelect('u')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
