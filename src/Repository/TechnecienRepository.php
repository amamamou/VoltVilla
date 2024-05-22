<?php

namespace App\Repository;

use App\Entity\Technecien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Technecien>
 *
 * @method Technecien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Technecien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Technecien[]    findAll()
 * @method Technecien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnecienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Technecien::class);
    }
    public function countTechnicians(): int
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
//    /**
//     * @return Technecien[] Returns an array of Technecien objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Technecien
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

  // Define the method to find available technicians
  public function findAvailableTechnicians(): array
{
    return $this->createQueryBuilder('t')
        ->where('t.available = true')
        ->getQuery()
        ->getResult();
}

}
