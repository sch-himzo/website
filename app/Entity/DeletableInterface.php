<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

interface DeletableInterface
{
    public function delete(): void;

    public function isDeleted(): bool;

    public function getDeletedAt(): ?DateTimeInterface;
}