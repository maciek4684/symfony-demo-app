<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends SortableRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Task::class));
    }

    public function findUserSubmits($user_id)
    {

        $em = $this->getEntityManager();

        $rsm = new ResultSetMapping($em);

        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('slug', 'slug');
        $rsm->addScalarResult('score', 'score');
        $rsm->addScalarResult('attempts', 'attempts');

        $sql = "
            SELECT t.id, t.slug, t.title, COALESCE(q.score, 0) as score, q.attempts
            FROM task AS t
            LEFT JOIN
            (
                -- select task id and score of the last tasksubmit
                SELECT ts.task_id, ts.score, q.attempts
                FROM task_submit as ts
                INNER JOIN
                (
                    -- select the last tasksubmit by a user
                    SELECT ts.task_id, max(ts.id) as id, count(ts.id) as attempts
                    FROM task_submit as ts
                    WHERE ts.user_id = $user_id
                    GROUP BY task_id
                ) AS q
                ON q.id = ts.id
            ) AS q
            ON q.task_id = t.id
            ";

        $query = $em->createNativeQuery($sql, $rsm);
        return $query->getResult();
    }

}
