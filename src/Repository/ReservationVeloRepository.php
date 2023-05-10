<?php

namespace App\Repository;

use App\Entity\ReservationVelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;


require_once __DIR__ . '/../../vendor/autoload.php';
/**
 * @extends ServiceEntityRepository<ReservationVelo>
 *
 * @method ReservationVelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationVelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationVelo[]    findAll()
 * @method ReservationVelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */



class ReservationVeloRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationVelo::class);
    }

    public function save(ReservationVelo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReservationVelo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function sendsms(): void
    {
        //require ('vendor\autoload.php');
        $sid = "AC6f7e613707d043a92b9f2a0d7114ddfe" ; 
        $token = "a83e9899178caa6d8d4461fac076f563" ; 
        $client = new Client ($sid, $token);

        $message = $client->messages
            ->create("+21655249321", // to
                ["body" => "vous avez une nouvelle reservation!", "from" => "+16813213290"]
            );

    }
    public function findBySearch($search, $category, $price)
    { 
        $qb = $this->createQueryBuilder('r')
                ->leftJoin('r.idStation', 's')
                ->leftJoin('r.idVelo', 'v')
                ->where('r.idReservation LIKE :search OR s.nomStation LIKE :search OR v.titre LIKE :search');
        
        if ($category) {
            $qb->andWhere('v.titre LIKE :category')
                ->setParameter('category', $category);
        }
        
        if ($price) {
            $qb->andWhere('r.prixr*r.nbr <= :price')
                ->setParameter('price', $price);
        }
        
        $qb->setParameter('search', '%'.$search.'%')
            ->orderBy('r.prixr*r.nbr', 'ASC');
    
        return $qb->getQuery()->getResult();
    }
    


//    /**
//     * @return ReservationVelo[] Returns an array of ReservationVelo objects
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

//    public function findOneBySomeField($value): ?ReservationVelo
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
