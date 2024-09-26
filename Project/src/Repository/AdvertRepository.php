<?php

namespace App\Repository;

use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Advert>
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    // 3 latest advert posted (and still open)
    public function latest(){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT a
            FROM App\Entity\Advert a
            WHERE a.isOpen = true
            ORDER BY a.id DESC')->setMaxResults(3);
        $adverts = $query->getResult();
        return $adverts;
    }


    // 'SELECT a, c
    // FROM App\Entity\Advert a
    // LEFT OUTER JOIN a.comments c
    // WHERE a.isOpen = true
    // ORDER BY a.id DESC');

    // ->setMaxResults(3);

}
