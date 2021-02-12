<?php

namespace App\Repository;

use App\Entity\Salary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salary[]    findAll()
 * @method Salary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salary::class);
    }


    /**
     * @param string $q
     * @return Salary[]
     */

    public function findTeacherBySalary(string $q)
    {
        return $this->createQueryBuilder('s')
            ->join('s.mission', 'm')
            ->join('m.teacher', 't')
            ->andWhere('t.fullName LIKE :val')
            ->setParameter('val', '%' . $q . '%')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
