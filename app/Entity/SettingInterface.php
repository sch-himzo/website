<?php

declare(strict_types=1);

namespace App\Entity;

interface SettingInterface extends
    ResourceInterface,
    NameableInterface,
    TimestampableInterface
{
    public function getSetting(): ?string;

    public function setSetting(?string $setting): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}