<?php

declare(strict_types=1);

namespace App\Traits;

use DateTimeInterface;

interface ArchiveableInterface
{
    public function isArchived(): bool;

    public function getArchivedAt(): ?DateTimeInterface;

    public function setArchivedAt(?DateTimeInterface $archivedAt): void;
}
