<?php

declare(strict_types=1);

namespace App\Traits;

use DateTimeInterface;

trait TimestampableTrait
{
    /** @var DateTimeInterface */
    private $createdAt;

    /** @var DateTimeInterface */
    private $updatedAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setCreatedAtNow(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    public function setUpdatedAtNow(): void
    {
        $this->updatedAt = new \DateTime('now');
    }
}
