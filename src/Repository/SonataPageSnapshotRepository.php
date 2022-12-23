<?php

namespace App\Repository;

use App\Entity\SonataPageSnapshot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * @method SonataPageSnapshotRepository |null find($id, $lockMode = null, $lockVersion = null)
 * @method SonataPageSnapshotRepository |null findOneBy(array $criteria, array $orderBy = null)
 * @method SonataPageSnapshotRepository []    findAll()
 * @method SonataPageSnapshotRepository []    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SonataPageSnapshotRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SonataPageSnapshot::class);
    }

    public function save(SonataPageSnapshot  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SonataPageSnapshot  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SonataPageSnapshot[] Returns an array of SonataPageSnapshot objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SonataPageSnapshot
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}