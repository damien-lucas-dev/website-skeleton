<?php

namespace App\Repository;

use App\Entity\Annulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annulation[]    findAll()
 * @method Annulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annulation::class);
    }

    public function findAnnulationDeSortie(int $idSortie, int $idUsr)
    {
        return $this->createQueryBuilder('a')
            ->where('a.sortie = :idS')
            ->setParameter('idS', $idSortie)
            ->andWhere('a.utilisateur = :idU')
            ->setParameter('idU', $idUsr)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Annulation[] Returns an array of Annulation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annulation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
