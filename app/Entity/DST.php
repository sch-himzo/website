<?php

declare(strict_types=1);

namespace App\Entity;

class DST implements DSTInterface
{
    /** @var array $stitches */
    private $stitches = [];

    /** @var int $colorCount */
    private $colorCount = 0;

    /** @var int $stitchCount */
    private $stitchCount = 0;

    /** @var float $maxHorizontalPosition */
    private $maxHorizontalPosition = 0.0;

    /** @var float $maxVerticalPosition */
    private $maxVerticalPosition = 0.0;

    /** @var float $minHorizontalPosition */
    private $minHorizontalPosition = 0.0;

    /** @var float $minVerticalPosition */
    private $minVerticalPosition = 0.0;

    /** @var array $currentPosition */
    private $currentPosition = [0.0, 0.0];

    public function getStitches(): array
    {
        return $this->stitches;
    }

    public function setStitches(array $stitches): void
    {
        $this->stitches = $stitches;
    }

    public function getColorCount(): int
    {
        return $this->colorCount;
    }

    public function setColorCount(int $colorCount): void
    {
        $this->colorCount = $colorCount;
    }

    public function incrementColorCount(): void
    {
        $this->colorCount++;
    }

    public function getStitchCount(): int
    {
        return $this->stitchCount;
    }

    public function setStitchCount(int $stitchCount): void
    {
        $this->stitchCount = $stitchCount;
    }

    public function incrementStitchCount(): void
    {
        if ($this->stitchCount === null) {
            $this->stitchCount = 0;
        }

        $this->stitchCount++;
    }

    public function getMaxHorizontalPosition(): float
    {
        return $this->maxHorizontalPosition;
    }

    public function setMaxHorizontalPosition(float $maxHorizontalPosition): void
    {
        $this->maxHorizontalPosition = $maxHorizontalPosition;
    }

    public function getMaxVerticalPosition(): float
    {
        return $this->maxVerticalPosition;
    }

    public function setMaxVerticalPosition(float $maxVerticalPosition): void
    {
        $this->maxVerticalPosition = $maxVerticalPosition;
    }

    public function getMinHorizontalPosition(): float
    {
        return $this->minHorizontalPosition;
    }

    public function setMinHorizontalPosition(float $minHorizontalPosition): void
    {
        $this->minHorizontalPosition = $minHorizontalPosition;
    }

    public function getMinVerticalPosition(): float
    {
        return $this->minVerticalPosition;
    }

    public function setMinVerticalPosition(float $minVerticalPosition): void
    {
        $this->minVerticalPosition = $minVerticalPosition;
    }

    public function getCurrentPosition(): array
    {
        return $this->currentPosition;
    }

    public function setCurrentPosition(array $currentPosition): void
    {
        $this->currentPosition = $currentPosition;
    }

    public function addStitchByNextPosition(array $position): void
    {
        $this->stitches[$this->colorCount][] = [$this->currentPosition, $position];
    }

    public function getCanvasWidth(): float
    {
        return abs($this->maxHorizontalPosition) + abs($this->minHorizontalPosition) + 10;
    }

    public function getCanvasHeight(): float
    {
        return abs($this->maxVerticalPosition) + abs($this->minVerticalPosition) + 10;
    }
}
