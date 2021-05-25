<?php

declare(strict_types=1);

namespace App\Entity;

interface TemporaryUserInterface extends ResourceInterface, NameableInterface, TimestampableInterface
{
    public function getEmail(): ?string;

    public function setEmail(?string $email): void;
}