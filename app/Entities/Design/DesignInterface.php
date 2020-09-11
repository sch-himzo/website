<?php

declare(strict_types=1);

namespace App\Entities\Design;

use App\Entities\Inventory\BackgroundInterface;
use App\Traits\DeletableInterface;
use App\Traits\EntityInterface;
use App\Traits\OrderAwareInterface;
use App\Traits\TimestampableInterface;

interface DesignInterface extends
    EntityInterface,
    TimestampableInterface,
    DeletableInterface,
    OrderAwareInterface
{
    public function getDesignGroup(): ?DesignGroupInterface;

    public function setDesignGroup(?DesignGroupInterface $designGroup): void;

    public function getFile(): ?string;

    public function setFile(?string $file): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getColorCount(): ?int;

    public function setColorCount(?int $colorCount): void;

    public function hasColorCount(): bool;

    public function getStitchCount(): ?int;

    public function setStitchCount(?int $stitchCount): void;

    public function hasStitchCount(): bool;

    public function getSize(): ?float;

    public function setSize(?float $size): void;

    public function hasSize(): bool;

    public function getBackground(): ?BackgroundInterface;

    public function setBackground(?BackgroundInterface $background): void;

    public function hasBackground(): bool;

    public function getSVG(): ?string;

    public function setSVG(?string $svg): void;

    public function hasSVG(): bool;

    public function getBytes(): ?string;

    public function setBytes(?string $bytes): void;

    public function hasBytes(): bool;
}
