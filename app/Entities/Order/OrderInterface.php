<?php

declare(strict_types=1);

namespace App\Entities\Order;

use App\Entities\User\TemporaryUserInterface;
use App\Entities\User\UserInterface;
use App\Traits\ArchiveableInterface;
use App\Traits\DeletableInterface;
use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;
use App\Traits\UserAwareInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface OrderInterface extends
    EntityInterface,
    TimestampableInterface,
    UserAwareInterface,
    ArchiveableInterface,
    DeletableInterface
{
    const STATUS_NEW = 'new';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DESIGNED = 'designed';
    const STATUS_EMBROIDERED = 'embroidered';
    const STATUS_PAID = 'paid';
    const STATUS_DONE = 'done';

    const STATUS_MAP = [
        self::STATUS_NEW => 'Elfogadásra vár',
        self::STATUS_ACCEPTED => 'Elfogadva',
        self::STATUS_DESIGNED => 'Tervezve',
        self::STATUS_EMBROIDERED => 'Hímezve',
        self::STATUS_PAID => 'Fizetve',
        self::STATUS_DONE => 'Kész'
    ];

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function isInternal(): bool;

    public function setInternal(bool $internal): void;

    public function getComment(): ?string;

    public function setComment(?string $comment): void;

    public function getApprovedBy(): ?UserInterface;

    public function setApprovedBy(?UserInterface $user): void;

    public function getTemporaryUser(): ?TemporaryUserInterface;

    public function setTemporaryUser(?TemporaryUserInterface $temporaryUser): void;

    public function getStatus(): string;

    public function setStatus(?string $status): void;

    public function isPublicAlbums(): bool;

    public function setPublicAlbums(bool $publicAlbums): void;

    public function isJointProject(): bool;

    public function setJointProject(bool $joint): void;

    public function isHelpRequired(): bool;

    public function setHelpRequired(bool $helpRequired): void;

    public function getTimeLimit(): ?DateTimeInterface;

    public function setTimeLimit(?DateTimeInterface $timeLimit): void;

    public function getETA(): ?DateTimeInterface;

    public function setETA(?DateTimeInterface $eta): void;

    public function isSpam(): bool;

    public function setSpam(bool $spam): void;

    public function getReportedBy(): ?UserInterface;

    public function setReportedBy(?UserInterface $reportedBy): void;

    public function getItems(): ArrayCollection;

    public function hasItem(OrderItemInterface $orderItem): bool;

    public function hasItems(): bool;

    public function addItem(OrderItemInterface $orderItem): void;

    public function removeItem(OrderItemInterface $orderItem): void;

    public function removeItems(): void;
}
