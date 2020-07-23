<?php

namespace App\Repository;

use App\Entity\Qcm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Qcm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qcm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qcm[]    findAll()
 * @method Qcm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QcmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qcm::class);
    }

    // /**
    //  * @return Qcm[] Returns an array of Qcm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qcm
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findnbassigne($idqcm){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT count(id) as nbassigne
            FROM resultat 
            where qcm_id = :idqcm 
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['idqcm' => $idqcm]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function nbquestiondispo($idqcm){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(id) as nbquestion
            FROM question 
            where  qcm_id=:idqcm
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['idqcm' => $idqcm]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function qcmaffiche($idqcm){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT  question.libelle_question as question, proposition.libelle_proposition AS proposition, proposition.resultat_vrai_faux as resultat
            FROM question
            INNER JOIN proposition ON question.id=proposition.question_id
            WHERE question.qcm_id=:idqcm
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['idqcm' => $idqcm]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
