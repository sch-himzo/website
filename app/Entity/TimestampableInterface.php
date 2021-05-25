<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

interface TimestampableInterface
{
    public function getCreatedAt(): ?DateTimeInterface;

    public function setCreatedAtNow(): void;

    public function getUpdatedAt(): ?DateTimeInterface;

    public function setUpdatedAtNow(): void;
}