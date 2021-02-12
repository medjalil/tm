<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    /**
     * @param string $q
     * @return Mission[]
     */

    public function findMissionByCriteria(string $q): array
    {
        return $this->createQueryBuilder('m')
            ->join('m .teacher', 't')
            ->join('m.city', 'c')
            ->join('m.school', 's')
            ->andWhere('t.fullName LIKE :val')
            ->orWhere('c.name LIKE :val')
            ->orWhere('s.name LIKE :val')
            ->setParameter('val', '%' . $q . '%')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param bool $type
     * @return Mission[]
     */
    public function countMissionsByType(bool $type): array
    {
        return $this->createQueryBuilder('m')
            ->join('m .teacher', 't')
            ->andWhere('t.archived = 0')
            ->andWhere('m.type LIKE :val')
            ->setParameter('val', $type)
            ->getQuery()
            ->getResult();
    }


}
