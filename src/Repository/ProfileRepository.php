<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }


    public function getprofileList( $user ) {
        // on prend les preferences du user
        $preference = $user->getProfile()->getPreference();
        // on traite ses préférences
        $sex = $preference->getSex();
        $arrayAgeRange = explode(' ', $preference->getAgeRange());
        $dateMin = date("Y-m-d", strtotime("-".$arrayAgeRange[0]."years"));
        $dateMax = date("Y-m-d", strtotime("-".$arrayAgeRange[2]."years"));
        $postCode = $preference->getCountry();

        // on crée la requete :
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->join('p.user', 'user');
        $queryBuilder->where('p.sex = :sex' );
        $queryBuilder->setParameter('sex', $sex);
        $queryBuilder->andWhere('p.dateBirthday <= :dateMin' );
        $queryBuilder->setParameter('dateMin', $dateMin);
        $queryBuilder->andWhere('p.dateBirthday >= :dateMax' );
        $queryBuilder->setParameter('dateMax', $dateMax);
        //$PostCodeBdd = $queryBuilder->expr()->substring('p.codePostal', 0, 2);
        $queryBuilder->andWhere(
            $queryBuilder->expr()->eq(
                $queryBuilder->expr()->substring('p.codePostal', 1, 2),
                ':postCode' )
        );
        $queryBuilder->setParameter('postCode', $postCode);
        $queryBuilder->addSelect('user');
        // on recupere l'objet Query de doctrine
        $query = $queryBuilder->getQuery();

        return $query->execute();
    }



    // /**
    //  * @return Profile[] Returns an array of Profile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
