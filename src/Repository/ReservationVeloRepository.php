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
        $token = "e914e391fca762e7c11f39d254b96675" ; 
        $client = new Client ($sid, $token);

        $message = $client->messages
            ->create("+21655249321", // to
                ["body" => "vous avez un nouveau offre sur BePro!", "from" => "+16813213290"]
            );

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
