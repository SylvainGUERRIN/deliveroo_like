<?php


namespace App\Repository;


use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CityRepository
 * @package App\Repository
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
     * @param $name
     * @return int|mixed|string|null
     */
    public function findByName($name)
    {
        return $this->createQueryBuilder('c')
            ->where('c.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $name
     * @param $zipCode
     * @return int|mixed|string|null
     */
    public function findByNameAndZipCode($name, $zipCode)
    {
        return $this->createQueryBuilder('c')
            ->where('c.name = :val')
            ->andWhere('c.zipCode = :zip')
            ->setParameter('val', $name)
            ->setParameter('zip', $zipCode)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $search
     * @return int|mixed|string
     */
    public function searchCity($search)
    {
        return $this->createQueryBuilder('c')
            ->where('c.name LIKE :val')
            ->setParameter('val', '%' . $search . '%')
            ->getQuery()
            ->getResult()
            ;
    }
}
