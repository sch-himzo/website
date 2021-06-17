<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\NewsItem;
use App\Entity\RoleInterface;
use Doctrine\Common\Collections\Collection;

class NewsItemRepository extends AbstractEntityRepository implements NewsItemRepositoryInterface
{
    protected function getClass(): string
    {
        return NewsItem::class;
    }

    public function findAllViewable(RoleInterface $role): Collection
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.role_id <= :role_id')
            ->setParameter('role_id', $role->getId())
            ->getQuery()
            ->getResult();
    }
}