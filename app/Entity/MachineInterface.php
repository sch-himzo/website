<?php

declare(strict_types=1);

namespace App\Entity;

interface MachineInterface extends
    ResourceInterface,
    TimestampableInterface,
    RoleAwareInterface
{
    public const STATE_RUNNING = 'running';
    public const STATE_END = 'end';
    public const STATE_MACHINE_ERROR = 'machine_error';
    public const STATE_STOPPED = 'stopped';
    public const STATE_THREAD_BREAK = 'thread_break';

    public const PROGRESS_BAR_ACTIVE = 'progress-bar progress-bar-striped active';
    public const PROGRESS_BAR_END = 'progress-bar-success progress-bar-striped';
    public const PROGRESS_BAR_WARNING = 'progress-bar-warning progress-bar-striped';
    public const PROGRESS_BAR_DANGER = 'progress-bar-danger progress-bar-striped';

    public const STATE_PROGRESS_BAR_MAP = [
        self::STATE_RUNNING => self::PROGRESS_BAR_ACTIVE,
        self::STATE_END => self::PROGRESS_BAR_END,
        self::STATE_MACHINE_ERROR => self::PROGRESS_BAR_DANGER,
        self::STATE_STOPPED => self::PROGRESS_BAR_WARNING,
        self::STATE_THREAD_BREAK => self::PROGRESS_BAR_DANGER,
    ];

    public function getState(): ?string;

    public function setState(?string $state): void;

    public function getCurrentStitch(): ?int;

    public function setCurrentStitch(?int $currentStitch): void;

    public function getStitchCount(): ?int;

    public function setStitchCount(?int $stitchCount);

    public function getCurrentDesign(): ?int;

    public function setCurrentDesign(?int $currentDesign);

    public function getDesignCount(): ?int;

    public function setDesignCount(?int $designCount);

    public function hasFile(): bool;

    public function getFile(): ?FileInterface;

    public function setFile(?FileInterface $file): void;

    public function getWidth(): ?float;

    public function setWidth(?float $width): void;

    public function getHeight(): ?float;

    public function setHeight(?float $height): void;

    public function getHorizontalOffset(): ?float;

    public function setHorizontalOffset(?float $horizontalOffset): void;

    public function getVerticalOffset(): ?float;

    public function setVerticalOffset(?float $verticalOffset);

    public function getSecondsPassed(): ?int;

    public function setSecondsPassed(?int $secondsPassed): void;

    public function getStitches(): ?array;

    public function setStitches(?array $stitches): void;
}