<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

interface OrderInterface extends
    ResourceInterface,
    TimestampableInterface,
    NameableInterface,
    UserAwareInterface,
    DeletableInterface,
    CommentableInterface
{
    public const PAYMENT_TYPE_INTERNAL = 'internal';
    public const PAYMENT_TYPE_EXTERNAL = 'external';

    public const STATE_DRAFT = 'draft';
    public const STATE_PLACED = 'placed';
    public const STATE_APPROVED = 'approved';
    public const STATE_DESIGNED = 'designed';
    public const STATE_EMBROIDERED = 'embroidered';
    public const STATE_PAID = 'paid';
    public const STATE_DONE = 'archived';

    public function getComment(): ?string;

    public function setComment(?string $comment): void;

    public function getApprovedBy(): ?UserInterface;

    public function setApprovedBy(?UserInterface $approvedBy): void;

    public function getPaymentType(): ?string;

    public function setPaymentType(?string $paymentType): void;

    public function getTemporaryUser(): ?TemporaryUserInterface;

    public function setTemporaryUser(?TemporaryUserInterface $temporaryUser): void;

    public function getState(): string;

    public function setState(string $status): void;

    public function isAlbumPublicity(): bool;

    public function setAlbumPublicity(?bool $albumPublicity): void;

    public function isJoint(): bool;

    public function setJoint(?bool $joint): void;

    public function isHelpNeeded(): bool;

    public function setHelpNeeded(?bool $helpNeeded): void;

    public function getDeadline(): ?DateTimeInterface;

    public function setDeadline(?DateTimeInterface $deadline): void;

    public function getEstimatedCompletionDate(): ?DateTimeInterface;

    public function setEstimatedCompletionDate(?DateTimeInterface $estimatedCompletionDate): void;

    public function isMarkedAsSpam(): bool;

    public function setMarkedAsSpam(?bool $markedAsSpam): void;

    public function getMarkedBy(): ?UserInterface;

    public function setMarkedBy(?UserInterface $markedBy): void;
}