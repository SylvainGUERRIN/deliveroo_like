<?php

namespace App\Repository;

use App\Entity\DisLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DisLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisLike[]    findAll()
 * @method DisLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DisLike::class);
    }
}
