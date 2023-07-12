<?php

namespace App\Repository;

use App\Entity\WineBlend;
use App\Entity\Workshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WineBlend>
 *
 * @method WineBlend|null find($id, $lockMode = null, $lockVersion = null)
 * @method WineBlend|null findOneBy(array $criteria, array $orderBy = null)
 * @method WineBlend[]    findAll()
 * @method WineBlend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineBlendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WineBlend::class);
    }

    public function countByWorkshop(Workshop $workshop): int
    {
        return $this->createQueryBuilder('wb')
            ->select('COUNT(wb)')
            ->andWhere('wb.workshop = :workshop')
            ->setParameter('workshop', $workshop)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findHighestScore(): ?WineBlend
    {
        return $this->createQueryBuilder('wb')
            ->orderBy('wb.scoreWineblend', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(WineBlend $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WineBlend $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countUserByWS(int $workshopId): int
    {
        return $this->createQueryBuilder('wb')
            ->select('COUNT(DISTINCT u.id)')
            ->leftJoin('wb.user', 'u')
            ->andWhere('wb.workshop = :workshopId')
            ->setParameter('workshopId', $workshopId)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return WineBlend[] Returns an array of WineBlend objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WineBlend
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
