<?php

namespace App\Repository;

use App\Entity\Hangout;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hangout>
 *
 * @method Hangout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hangout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hangout[]    findAll()
 * @method Hangout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HangoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hangout::class);
    }

    public function add(Hangout $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Hangout $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByFilter($campus, $name, $startDate, $endDate, $imOrginizer, $imIn, $imNotIn, $pastHangout){
        $queryFilter = $this->createQueryBuilder('h')
            ->orderBy('h.startTime', 'ASC');
        if($campus){
            $queryFilter->andWhere('h.campusOrganizerSite =:campus')
                ->setParameter('campus', $campus);
        }
        if($name){
            $queryFilter->andWhere('h.name LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }
        if($name) {
            $queryFilter->andWhere('h.name LIKE :name ')
                ->setParameter('name', '%'.$name.'%');
        }

        $res = $queryFilter->getQuery();
        return $res->getResult();
    }




//    /**
//     * @return Hangout[] Returns an array of Hangout objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hangout
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
