<?php

declare(strict_types=1);

namespace App\Entity;

interface UserAwareInterface
{
    public function hasUser(): bool;

    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user): void;
}