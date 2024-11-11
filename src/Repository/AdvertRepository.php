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
    public function latest() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
        ->from('App\Entity\Advert', 'a')
        ->select('a')
        ->where('a.isOpen = true')
        ->orderBy('a.publishDate', 'desc')
        ->setMaxResults(3);
        $adverts = $qb->getQuery()->getResult();
        return $adverts;
    }
    
    // filtres app_advert_index
    public function filterSearch(array $data) {
        $qb = $this->createQueryBuilder('a')
            ->groupBy('a.id')
            ->where('a.isOpen = true')
            // tri popularité
            ->leftJoin('a.comments', 'c')
            ->addSelect('COUNT(c.id) AS HIDDEN popularity')
            // tri par défaut
            ->orderBy('a.publishDate', 'desc');
        
        // filtre date
        if (isset($data['after'])) {
            $qb->andWhere('a.publishDate > :after')
            ->setParameter('after', $data['after']);
        }
        if (isset($data['before'])) {
            $qb->andWhere('a.publishDate < :before')
            ->setParameter('before', $data['before']);
        }

        // filtre tags
        $tagTypes = ['game', 'genre', 'level', 'modality'];
        $tagConditions = [];
        $parameters = [];

        foreach ($tagTypes as $type) {
            if (isset($data[$type])) {
                $tagConditions[] = "tag.type = :{$type}Type AND tag.name = :{$type}Name";
                $parameters["{$type}Type"] = $type;
                $parameters["{$type}Name"] = $data[$type]->getName();
            }
        }

        if (!empty($tagConditions)) {
            $qb->leftJoin('a.tags', 'tag')
                ->andWhere(implode(' OR ', $tagConditions));

            foreach ($parameters as $k => $v) {
                $qb->setParameter($k, $v);
            }
    
            $qb->having('COUNT(DISTINCT tag.id) = :expectedTagCount')
                ->setParameter('expectedTagCount', count($tagConditions));
        }

        // debug
        // dd($data, $qb->getQuery(), $qb->getQuery()->getResult());

        return $qb;
    }

}
