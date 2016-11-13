<?php

namespace Gsquad\BlogBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    //TODO Récupérer les posts en ordre chronologique décroissant
    //TODO Récupérer commentaires associés à l'article
    //TODO Mettre en place une pagination
    //TODO Récupérer par catégorie
    public function getAllPosts($currentPage = 1)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.creationDate', 'DESC')
            ->getQuery();
        dump($query);

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page -1))
            ->setMaxResults($limit);

        return $paginator;
    }

    public function countPublishedTotal()
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', 'published')
            ->select('COUNT(p)')
        ;

        return $qb->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
