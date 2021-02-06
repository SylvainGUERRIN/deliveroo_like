<?php

namespace App\Repository;

use App\Data\SortingData;
use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Restaurant::class);
        $this->paginator = $paginator;
    }

    /**
     * @param SortingData $sortingData
     * @return PaginationInterface
     */
    public function findSortingData(SortingData $sortingData): PaginationInterface
    {
        $query = $this->getSortingQuery($sortingData)->getQuery();
        return $this->paginator->paginate($query, $sortingData->page, 9);
    }

    /**
     * @param SortingData $sortingData
     * @return QueryBuilder
     */
    private function getSortingQuery(SortingData $sortingData): QueryBuilder
    {
        $query = $this->createQueryBuilder('r')
            ->select('c','r')
            ->join('r.category', 'c');
        if(!empty($sortingData->q)){
            $query = $query
                ->andWhere('r.name LIKE :q')
                ->setParameter('q', "%{$sortingData->q}%");
        }
        if(!empty($search->categories)){
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $sortingData->categories);
        }
        return $query;
    }
}
