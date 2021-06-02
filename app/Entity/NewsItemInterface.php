<?php

declare(strict_types=1);

namespace App\Entity;

interface NewsItemInterface extends
    ResourceInterface,
    NameableInterface,
    RoleAwareInterface,
    TimestampableInterface,
    UserAwareInterface
{
    public function getContent(): ?string;

    public function setContent(?string $content);

    public function isAlert(): bool;

    public function setAlert(bool $alert): void;
}