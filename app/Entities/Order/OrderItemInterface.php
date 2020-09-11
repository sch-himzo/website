<?php

declare(strict_types=1);

namespace App\Entities\Order;

use App\Entities\Design\DesignGroupInterface;
use App\Entities\Gallery\AlbumInterface;
use App\Entities\User\UserInterface;
use App\Traits\DeletableInterface;
use App\Traits\EntityInterface;
use App\Traits\OrderAwareInterface;
use App\Traits\TimestampableInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface OrderItemInterface extends
    TimestampableInterface,
    EntityInterface,
    OrderAwareInterface,
    DeletableInterface
{
    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function getAmount(): int;

    public function setAmount(int $amount): void;

    public function getTimeLimit(): ?DateTimeInterface;

    public function setTimeLimit(?DateTimeInterface $timeLimit): void;

    public function hasTimeLimit(): bool;

    public function getType(): string;

    public function setType(string $type): void;

    public function getSize(): ?string;

    public function setSize(?string $size): void;

    public function getFont(): ?string;

    public function setFont(?string $font): void;

    public function getComment(): ?string;

    public function setComment(?string $comment): void;

    public function getStatus(): ?string;

    public function setStatus(?string $status): void;

    public function isExistingDesign(): bool;

    public function setExistingDesign(bool $existingDesign): void;

    public function getFinalDiameter(): ?float;

    public function setFinalDiameter(?float $finalDiameter): void;

    public function getDesignGroup(): ?DesignGroupInterface;

    public function setDesignGroup(?DesignGroupInterface $designGroup): void;

    public function hasDesignGroup(): bool;

    public function getTestAlbum(): ?AlbumInterface;

    public function setTestAlbum(?AlbumInterface $album): void;

    public function hasTestAlbum(): bool;

    public function isMarkedSpam(): bool;

    public function setMarkedSpam(bool $markedSpam): void;

    public function getMarkedBy(): ?UserInterface;

    public function setMarkedBy(?UserInterface $markedBy): void;

    public function hasMarkedBy(): bool;

    public function getImages(): ArrayCollection;

    public function hasImage(OrderImageInterface $orderImage): bool;

    public function hasImages(): bool;

    public function addImage(OrderImageInterface $orderImage): void;

    public function removeImage(OrderImageInterface $orderImage): void;

    public function removeImages(): void;
}
