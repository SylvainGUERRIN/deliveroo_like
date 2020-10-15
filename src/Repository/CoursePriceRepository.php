<?php

namespace App\Repository;

use App\Entity\CoursePrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AddressRepository
 * @package App\Repository
 * @method CoursePrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoursePrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoursePrice[]    findAll()
 * @method CoursePrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursePriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursePrice::class);
    }
}
