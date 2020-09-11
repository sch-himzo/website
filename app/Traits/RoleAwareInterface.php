<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\User\RoleInterface;

interface RoleAwareInterface
{
    public function getRole(): ?RoleInterface;

    public function setRole(?RoleInterface $role): void;

    public function hasRole(): bool;
}
