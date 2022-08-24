<?php

namespace App\Repository;

use App\Entity\TaskSubmit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping as ResultSetMapping;

/**
 * @method TaskSubmit|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskSubmit|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskSubmit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskSubmitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskSubmit::class);
    }

}