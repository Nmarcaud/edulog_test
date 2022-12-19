<?php

namespace App\Repository;

use App\Entity\Deadline;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Deadline>
 *
 * @method Deadline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deadline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deadline[]    findAll()
 * @method Deadline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeadlineRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $em
    )
    {
        parent::__construct($registry, Deadline::class);
    }

    public function save(Deadline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Deadline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findNextDeadlines() {

        // Semaine + 1
        $today = strtotime(date('Y-m-d'));
        $nextWeek = strtotime("+7 days", $today);

        // Get Vendredi ?

        $conn = $this->em->getConnection();
        $sql = "SELECT *
                FROM deadline
                WHERE due_date <= $nextWeek 
                AND is_done = false 
                ";
        $stmt = $conn->executeQuery($sql);
        return $stmt->fetchAllAssociative();
    }


//    /**
//     * @return Deadline[] Returns an array of Deadline objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Deadline
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
