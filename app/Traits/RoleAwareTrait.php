<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\User\RoleInterface;

trait RoleAwareTrait
{
    /** @var RoleInterface|null */
    private $role;

    public function getRole(): ?RoleInterface
    {
        return $this->role;
    }

    public function setRole(?RoleInterface $role): void
    {
        $this->role = $role;
    }

    public function hasRole(): bool
    {
        return isset($this->role);
    }
}
