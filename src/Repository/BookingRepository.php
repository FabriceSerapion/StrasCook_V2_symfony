<?php

namespace App\Repository;

use DateTime;
use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllBookings(
        int $limit = 0,
        string $orderBy = '',
        string $direction = 'ASC',
        int $idUser = 0,
        string $bookingDate = ''
    ): array {
        $query = $this->createQueryBuilder('b')
            ->select('b', 'b.date', 'b.time', 'b.adress', 'b.quantity', 'b.price', 'c.firstname','m.name')
            ->innerJoin('b.cook','c')
            ->leftJoin('b.menu','m');
            if ($idUser > 0) {
                $query 
                ->andWhere('b.customer = :idUser')
                ->setParameter('idUser', $idUser);
            }
            if ($bookingDate) {
                $datenew = DateTime::createFromFormat("Y-m-d", $bookingDate);
                $query 
                ->andwhere('b.date > :datenew')
                ->setParameter('datenew', $datenew);
            }
            if ($orderBy) {
                $query 
                ->orderBy($orderBy, $direction);
            }
            if ($limit > 0) {
                $query 
                ->setMaxResults($limit);
            }
        return $query->getQuery()
           ->getResult();
    }

    public function findLastId(int $idUser): Booking|false
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->where('b.customer = :idUser')
            ->setParameter('idUser', $idUser)
            ->getQuery()
            ->getResult()
    ;
    }

     /**
     * Get all ratings for one user from database by ID.
     */
    public function findAllMenuBooked(int $idUser): array|false
    {
    return $this->createQueryBuilder('b')
        ->innerJoin('b.menu','m')
        ->select('DISTINCT m.name, m.rating, m.id')
        ->where('b.customer = :idUser')
        ->setParameter('idUser', $idUser)
        ->getQuery()
        ->getResult()
    ;
    }

//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}