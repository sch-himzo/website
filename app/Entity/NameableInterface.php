<?php

declare(strict_types=1);

namespace App\Entity;

interface NameableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;
}