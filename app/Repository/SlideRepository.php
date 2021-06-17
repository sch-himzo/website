<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Slide;

class SlideRepository extends AbstractEntityRepository implements SlideRepositoryInterface
{
    protected function getClass(): string
    {
        return Slide::class;
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.number', 'ASC')
            ->getQuery()
            ->getResult();
    }
}