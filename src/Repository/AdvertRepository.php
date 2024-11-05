<?php

namespace App\Repository;

use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function PHPUnit\Framework\isNull;

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
        ->orderBy('a.id', 'desc')
        ->setMaxResults(3);
        $adverts = $qb->getQuery()->getResult();
        return $adverts;
    }
    
    // filtres app_advert_index
    public function filterSearch(array $data) {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
        ->select('a')
        ->from('App\Entity\Advert', 'a')
        ->innerJoin('a.tags', 't')
        ->where('a.isOpen = true');

        // filtre ordre
        switch($data['orderby']){
            case 'newest':
                $qb->orderBy('a.id', 'desc');
                break;
            case 'oldest':
                $qb->orderBy('a.id');
                break;
            case 'popularity':
                $qb->addSelect('COUNT(c.id) AS HIDDEN cCount')
                    ->leftJoin('a.comments', 'c')
                    ->groupBy('a.id')
                    ->orderBy('cCount', 'desc');
                break;
        }
        
        // filtre date
        if ($data['after']) {
            $qb->andWhere('a.publishDate > :after')
            ->setParameter('after', $data['after']);
        }
        if ($data['before']) {
            $qb->andWhere('a.publishDate < :before')
            ->setParameter('before', $data['before']);
        }

        // filtre tags
        if ($data['game']) {
            $qb->andWhere('t.type = :gaType')
            ->andWhere('t.name = :gaName')
                ->setParameter('gaType', $data['game']->getType())
                ->setParameter('gaName', $data['game']->getName());
        }
        if ($data['genre']) {
            $qb->andWhere('t.type = :geType')
                ->andWhere('t.name = :geName')
                ->setParameter('geType', $data['genre']->getType())
                ->setParameter('geName', $data['genre']->getName());
        }
        if ($data['level']) {
            $qb->andWhere('t.type = :lType')
            ->andWhere('t.name = :lName')
            ->setParameter('lType', $data['level']->getType())
            ->setParameter('lName', $data['level']->getName());
        }
        if ($data['modality']) {
            $qb->andWhere('t.type = :mType')
            ->andWhere('t.name = :mName')
            ->setParameter('mType', $data['modality']->getType())
            ->setParameter('mName', $data['modality']->getName());
        }

        // exécution requête
        $adverts = $qb->getQuery()->getResult();
        return $adverts;
    }

}