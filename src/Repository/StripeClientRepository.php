<?php

namespace App\Repository;

use App\Entity\StripeClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StripeClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method StripeClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method StripeClient[]    findAll()
 * @method StripeClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StripeClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StripeClient::class);
    }
}
