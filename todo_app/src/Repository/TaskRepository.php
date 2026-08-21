<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findFiltered(?string $status, ?string $priority): array
    {
        $query = $this->createQueryBuilder('task')
            ->orderBy('task.updatedAt', 'DESC');

        if ($status && in_array($status, Task::STATUSES, true)) {
            $query->andWhere('task.status = :status')->setParameter('status', $status);
        }
        if ($priority && in_array($priority, Task::PRIORITIES, true)) {
            $query->andWhere('task.priority = :priority')->setParameter('priority', $priority);
        }

        return $query->getQuery()->getResult();
    }
}