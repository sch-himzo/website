<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Machine;

class MachineRepository extends AbstractEntityRepository implements MachineRepositoryInterface
{
    protected function getClass(): string
    {
        return Machine::class;
    }
}