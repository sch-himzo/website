<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RoleInterface;

interface RoleRepositoryInterface
{
    public function findDefaultRole(): ?RoleInterface;
}