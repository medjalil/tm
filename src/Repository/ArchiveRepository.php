<?php

namespace App\Repository;

use App\Entity\Archive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Archive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archive[]    findAll()
 * @method Archive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archive::class);
    }

    /**
     * @param string $q
     * @return Archive[]
     */

    public function findTeacherByArchive(string $q)
    {
        return $this->createQueryBuilder('a')
            ->join('a .teacher', 't')
            ->andWhere('t.fullName LIKE :val')
            ->orWhere('t.cin LIKE :val')
            ->orWhere('t.phone LIKE :val')
            ->setParameter('val', '%' . $q . '%')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
