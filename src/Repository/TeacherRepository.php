<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    /**
     * @param string $q
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function findTeacherByCriteria(string $q): array
    {
        return $this->createQueryBuilder('t')
            ->Where('t.fullName Like :val')
            ->orWhere('t.phone Like :val')
            ->orWhere('t.cin Like :val')
            ->orWhere('t.pId Like :val')
            ->andWhere('t.archived = 0')
            ->setParameter('val', '%' . $q . '%')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
