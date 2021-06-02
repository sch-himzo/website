<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface FileInterface extends
    ResourceInterface,
    TimestampableInterface,
    DeletableInterface,
    NameableInterface,
    OrderAwareInterface
{
    public function hasFolder(): bool;

    public function getFolder(): ?FolderInterface;

    public function setFolder(?FolderInterface $folder): void;

    public function getPath(): ?string;

    public function setPath(?string $path): void;

    public function getColorCount(): ?int;

    public function setColorCount(?int $colorCount): void;

    public function getStitchCount(): ?int;

    public function setStitchCount(?int $stitchCount): void;

    public function getDiameter(): ?float;

    public function setDiameter(?float $diameter): void;

    public function getBackground(): ?BackgroundInterface;

    public function setBackground(?BackgroundInterface $background): void;

    public function getSvg(): ?string;

    public function setSvg(?string $svg): void;

    public function getBytes(): ?string;

    public function setBytes(?string $bytes): void;

    public function getColors(): Collection;

    public function hasColor(ColorInterface $color): bool;

    public function addColor(ColorInterface $color): void;

    public function removeColor(ColorInterface $color): void;
}