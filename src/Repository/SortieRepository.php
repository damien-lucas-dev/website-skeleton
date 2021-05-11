<?php

namespace App\Repository;

use App\Entity\PropertySearch;
use App\Entity\Sortie;
use App\Service\SortieService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findByFilter(array $filters, int $usrid)
    {
        $query = $this->createQueryBuilder('s');
        if ($filters['keyword'] != "") {
            $query->andWhere('s.nom LIKE :kw')
                ->orWhere('s.infosSortie LIKE :kw')
                ->setParameter('kw', '%' . $filters['keyword'] . '%');
        }

        if ($filters['lieu'] != "") {
            $query->andWhere('s.lieu = :lieu')
                ->setParameter('lieu', $filters['lieu']);
        }

        if (array_key_exists('owner', $filters)) {
            $query->andWhere('s.orga = :usrid')
                ->setParameter('usrid', $usrid);
        }

        if (array_key_exists('subscribed', $filters)) {
            $query->andWhere(':partid MEMBER OF s.participants')
                ->setParameter('partid', $usrid);
        }

        if (array_key_exists('passed', $filters)) {
            $query->andWhere('s.etat = :passed')
                ->setParameter('passed', SortieService::PASSEE);
        }

        if (array_key_exists('cancelled', $filters)) {
            $query->andWhere('s.etat = :cancelled')
                ->setParameter('cancelled', SortieService::ANNULEE);
        }

        return $query->getQuery()
                    ->getResult();
    }
    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
