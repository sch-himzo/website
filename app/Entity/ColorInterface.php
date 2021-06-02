<?php

declare(strict_types=1);

namespace App\Entity;

interface ColorInterface extends
    ResourceInterface,
    TimestampableInterface
{
    public const TYPE_ISACORD = 'isacord';
    public const TYPE_SULKY = 'sulky';

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function hasFile(): bool;

    public function getFile(): ?FileInterface;

    public function setFile(?FileInterface $file): void;

    public function getColor(): ?string;

    public function setColor(?string $color);

    public function getNumber(): ?int;

    public function setNumber(?int $number): void;

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getStitchCount(): ?int;

    public function setStitchCount(?int $stitchCount): void;

    public function isFancy(): bool;

    public function setFancy(bool $fancy): void;
}