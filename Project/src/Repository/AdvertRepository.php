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

    public function latest(){
        $limit = 3;
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT a FROM App\Entity\Advert a ORDER BY a.id DESC')->setMaxResults(3);
        $adverts = $query->getResult();
        return $adverts;
    }
}
