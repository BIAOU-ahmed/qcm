<?php

namespace App\Repository;

use App\Entity\Resultat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method Resultat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resultat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resultat[]    findAll()
 * @method Resultat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resultat::class);
    }

    
    public function CompteNbQCMRéalisés($eleve): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT COUNT(r)
            FROM App\Entity\Resultat r
            WHERE r.Eleve = :eleve
            AND r.realiseAt IS NOT NULL'
        )->setParameter('eleve', $eleve);

        // returns an array of Product objects
        return $query->getSingleScalarResult();
    }
    
    public function CalculMoyenneQCM($eleve,$nbqcmrea)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT SUM(r.note)
            FROM App\Entity\Resultat r
            WHERE r.Eleve = :eleve'
        )->setParameter('eleve', $eleve);

        
        if(floatval($nbqcmrea)){

        $moyenne = floatval ($query->getSingleScalarResult())/floatval($nbqcmrea) ;

        }
        return $moyenne;

    }


    // /**
    //  * @return Resultat[] Returns an array of Resultat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resultat
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
