<?php

declare(strict_types=1);

namespace App\Traits;

trait EntityTrait
{
    /** @var int $id */
    private $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
