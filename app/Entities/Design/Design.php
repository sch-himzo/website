<?php

declare(strict_types=1);

namespace App\Entities\Design;

use App\Entities\Inventory\BackgroundInterface;
use App\Traits\DeletableTrait;
use App\Traits\EntityTrait;
use App\Traits\OrderAwareTrait;
use App\Traits\TimestampableTrait;

class Design implements DesignInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use OrderAwareTrait;
    use DeletableTrait;

    /** @var DesignGroupInterface */
    private $designGroup;

    /** @var string */
    private $file;

    /** @var string */
    private $name;

    /** @var int */
    private $colorCount;

    /** @var int */
    private $stitchCount;

    /** @var float */
    private $size;

    /** @var BackgroundInterface|null */
    private $background;

    /** @var string */
    private $svg;

    /** @var string */
    private $bytes;

    public function getDesignGroup(): ?DesignGroupInterface
    {
        return $this->designGroup;
    }

    public function setDesignGroup(?DesignGroupInterface $designGroup): void
    {
        $this->designGroup = $designGroup;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): void
    {
        $this->file = $file;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getColorCount(): ?int
    {
        return $this->colorCount;
    }

    public function setColorCount(?int $colorCount): void
    {
        $this->colorCount = $colorCount;
    }

    public function hasColorCount(): bool
    {
        return isset($this->colorCount);
    }

    public function getStitchCount(): ?int
    {
        return $this->stitchCount;
    }

    public function setStitchCount(?int $stitchCount): void
    {
        $this->stitchCount = $stitchCount;
    }

    public function hasStitchCount(): bool
    {
        return isset($this->stitchCount);
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): void
    {
        $this->size = $size;
    }

    public function hasSize(): bool
    {
        return isset($this->size);
    }

    public function getBackground(): ?BackgroundInterface
    {
        return $this->background;
    }

    public function setBackground(?BackgroundInterface $background): void
    {
        $this->background = $background;
    }

    public function hasBackground(): bool
    {
        return isset($this->background);
    }

    public function getSVG(): ?string
    {
        return $this->svg;
    }

    public function setSVG(?string $svg): void
    {
        $this->svg = $svg;
    }

    public function hasSVG(): bool
    {
        return isset($this->svg);
    }

    public function getBytes(): ?string
    {
        return $this->bytes;
    }

    public function setBytes(?string $bytes): void
    {
        $this->bytes = $bytes;
    }

    public function hasBytes(): bool
    {
        return isset($this->bytes);
    }
}
