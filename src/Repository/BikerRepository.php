<?php

namespace App\Repository;

use App\Entity\Biker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BikerRepository
 * @package App\Repository
 * @method Biker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Biker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Biker[]    findAll()
 * @method Biker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BikerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Biker::class);
    }
}
