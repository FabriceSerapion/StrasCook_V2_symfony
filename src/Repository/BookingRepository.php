<?php

namespace App\Repository;

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

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAll(
        int $limit = 0,
        string $orderBy = '',
        string $direction = 'ASC',
        int $idUser = 0,
        string $bookingDate = ''
    ): Booking {
        $query = $this->createQueryBuilder('b')
            ->innerJoin('b.id','c');
            if ($idUser > 0) {
                $query=$this
                ->andWhere('booking.id_user = ' . $idUser);
            }
            if ($bookingDate) {
                $query=$this
                ->andwhere('booking.date_booking > "' . $bookingDate . '"');
            }
            if ($orderBy) {
                $query=$this
                ->orderBy($orderBy, $direction);
            }
            if ($limit > 0) {
                $query=$this
                 ->setMaxResults($limit);
            }
        return $this->getQuery()->getResult();
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
