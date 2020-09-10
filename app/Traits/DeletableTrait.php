<?php

declare(strict_types=1);

namespace App\Traits;

use DateTimeInterface;

trait DeletableTrait
{
    /** @var DateTimeInterface|null */
    private $deletedAt;

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
