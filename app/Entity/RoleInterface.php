<?php

declare(strict_types=1);

namespace App\Entity;

interface RoleInterface extends ResourceInterface, TimestampableInterface, NameableInterface
{
    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}