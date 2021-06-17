<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RoleInterface;
use Doctrine\Common\Collections\Collection;

interface NewsItemRepositoryInterface
{
    public function findAllViewable(RoleInterface $role): Collection;
}