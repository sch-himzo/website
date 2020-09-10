<?php

declare(strict_types=1);

namespace App\Traits;

use DateTimeInterface;

interface DeletableInterface
{
    public function isDeleted(): bool;

    public function getDeletedAt(): ?DateTimeInterface;

    public function setDeletedAt(?DateTimeInterface $deletedAt): void;
}
