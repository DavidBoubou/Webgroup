<?php

namespace App\Repository;

use App\Entity\SonataMediaGallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SonataMediaGallery>
 *
 * @method SonataMediaGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method SonataMediaGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method SonataMediaGallery[]    findAll()
 * @method SonataMediaGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SonataMediaGalleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SonataMediaGallery::class);
    }

    public function save(SonataMediaGallery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SonataMediaGallery $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SonataMediaGallery[] Returns an array of SonataMediaGallery objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SonataMediaGallery
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
