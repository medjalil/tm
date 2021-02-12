<?php

namespace App\Repository;

use App\Entity\Legation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Legation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Legation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Legation[]    findAll()
 * @method Legation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Legation::class);
    }
    
}
