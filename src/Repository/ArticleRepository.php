<?php

namespace App\Repository;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends Repository
{
    public function __construct(RegistryInterface $registry)
    {
        $this->class = Article::class;
        parent::__construct($registry);
    }

//    /**
//     * @return Article[] Returns last active articles order by createdOn 
//     */
    public function findByActiveOrderByCreatedOnQuery($active, $limit = null)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.active = :active')
            ->setParameter('active', $active)
            ->orderBy('a.createdOn', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
    }

    //    /**
//     * @return Article[] Returns last active articles order by createdOn
//     */
    public function findByTagActiveOrderByCreatedOnQuery($tag, $active, $limit = null)
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.tags', 't')
            ->where('t.slug = :tag')
            ->andWhere('a.active = :active')
            ->setParameter('active', $active)
            ->setParameter('tag', $tag)
            ->orderBy('a.createdOn', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
    }

    public function findByActiveOrderByCreatedOn($active, $limit)
    {
        return $this->findByActiveOrderByCreatedOnQuery($active, $limit)->getResult();
    }

    public function findByActiveOrderByCreatedOnPaginated($active = true,$currentPage = 1, $limit = 3)
    {
        $query = $this->findByActiveOrderByCreatedOnQuery($active);
        $paginator = $this->paginate($query, $currentPage, $limit);
        return array('paginator' => $paginator, 'query' => $query);
    }

    public function findByTagActiveOrderByCreatedOnPaginated($tag, $active = true, $currentPage = 1, $limit = 3){
        $query = $this->findByTagActiveOrderByCreatedOnQuery($tag, $active);
        $paginator = $this->paginate($query, $currentPage, $limit);
        return array('paginator' => $paginator, 'query' => $query);
    }


    /*
    public function findOneBySomeField($value): ?Article
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
