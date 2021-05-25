<?php

declare(strict_types=1);

namespace App\Entity;

interface DSTInterface
{
    public const COMMAND_LENGTH = 6;
    public const BYTE_LENGTH = 2;

    public const STITCH_TYPE_NORMAL = 'normal';
    public const STITCH_TYPE_COLOR_CHANGE = 'color_change';
    public const STITCH_TYPE_JUMP = 'jump';
    public const STITCH_TYPE_OTHER = 'other';

    public function getStitches(): array;

    public function setStitches(array $stitches): void;

    public function getColorCount(): int;

    public function setColorCount(int $colorCount): void;

    public function incrementColorCount(): void;

    public function getStitchCount(): int;

    public function setStitchCount(int $stitchCount): void;

    public function incrementStitchCount(): void;

    public function getMaxHorizontalPosition(): float;

    public function setMaxHorizontalPosition(float $maxHorizontalPosition): void;

    public function getMaxVerticalPosition(): float;

    public function setMaxVerticalPosition(float $maxVerticalPosition): void;

    public function getMinHorizontalPosition(): float;

    public function setMinHorizontalPosition(float $minHorizontalPosition): void;

    public function getMinVerticalPosition(): float;

    public function setMinVerticalPosition(float $minVerticalPosition): void;

    public function getCurrentPosition(): array;

    public function setCurrentPosition(array $currentPosition): void;

    public function addStitchByNextPosition(array $position): void;

    public function getCanvasWidth(): float;

    public function getCanvasHeight(): float;
}
