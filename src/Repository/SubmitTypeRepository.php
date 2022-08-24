<?php

namespace App\Repository;

use App\Entity\SubmitType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubmitType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubmitType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubmitType[]    findAll()
 * @method SubmitType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmitTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubmitType::class);
    }

}
