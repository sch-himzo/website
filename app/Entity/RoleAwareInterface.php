<?php

declare(strict_types=1);

namespace App\Entity;

interface RoleAwareInterface
{
    public function hasRole(): bool;

    public function getRole(): ?RoleInterface;

    public function setRole(RoleInterface $role): void;
}