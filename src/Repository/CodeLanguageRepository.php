<?php

namespace App\Repository;

use App\Entity\CodeLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CodeLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodeLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodeLanguage[]    findAll()
 * @method CodeLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodeLanguage::class);
    }

}
