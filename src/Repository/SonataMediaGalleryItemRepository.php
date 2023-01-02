<?php

namespace App\Repository;

use App\Entity\SonataMediaGalleryItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SonataMediaGalleryItem>
 *
 * @method SonataMediaGalleryItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SonataMediaGalleryItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SonataMediaGalleryItem[]    findAll()
 * @method SonataMediaGalleryItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SonataMediaGalleryItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SonataMediaGalleryItem::class);
    }

    public function save(SonataMediaGalleryItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SonataMediaGalleryItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SonataMediaGalleryItem[] Returns an array of SonataMediaGalleryItem objects
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

//    public function findOneBySomeField($value): ?SonataMediaGalleryItem
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
