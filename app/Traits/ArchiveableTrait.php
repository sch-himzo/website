<?php

declare(strict_types=1);

namespace App\Traits;

use DateTimeInterface;

trait ArchiveableTrait
{
    /** @var DateTimeInterface|null */
    private $archivedAt;

    public function isArchived(): bool
    {
        return $this->archivedAt !== null;
    }

    public function setArchivedAt(?DateTimeInterface $archivedAt): void
    {
        $this->archivedAt = $archivedAt;
    }

    public function getArchivedAt(): ?DateTimeInterface
    {
        return $this->archivedAt;
    }
}
