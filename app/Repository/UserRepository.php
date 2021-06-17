<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class UserRepository extends AbstractEntityRepository implements UserRepositoryInterface
{
    protected function getClass(): string
    {
        return User::class;
    }

    public function findAllInClub(): Collection
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.inClub = :inClub')
            ->setParameter('inClub', true)
            ->getQuery()
            ->getResult();
    }
}