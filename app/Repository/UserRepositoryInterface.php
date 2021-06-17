<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Common\Collections\Collection;

interface UserRepositoryInterface
{
    public function findAllInClub(): Collection;
}