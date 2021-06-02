<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

interface OrderItemInterface extends
    ResourceInterface,
    TimestampableInterface,
    DeletableInterface,
    NameableInterface,
    OrderAwareInterface,
    CommentableInterface
{
    public const STATE_DRAFT = 'draft';
    public const STATE_NEW = 'new';
    public const STATE_DESIGNED = 'designed';
    public const STATE_TEST_EMBROIDERED = 'test_embroidered';
    public const STATE_EMBROIDERED = 'embroidered';
    public const STATE_PAID = 'paid';
    public const STATE_COMPLETED = 'completed';

    public const TYPE_BADGE = 'badge';
    public const TYPE_JUMPER = 'jumper';
    public const TYPE_SHIRT = 'shirt';

    public function getQuantity(): ?int;

    public function setQuantity(?int $quantity): void;

    public function hasDeadline(): bool;

    public function getDeadline(): ?DateTimeInterface;

    public function setDeadline(?DateTimeInterface $deadline): void;

    public function getType(): string;

    public function setType(?string $type): void;

    public function getSize(): ?string;

    public function setSize(?string $size): void;

    public function getFont(): ?string;

    public function setFont(?string $font): void;

    public function getComment(): ?string;

    public function setComment(?string $comment): void;

    public function getState(): string;

    public function setState(?string $state): void;

    public function isOriginalDesign(): bool;

    public function setOriginalDesign(bool $originalDesign): void;

    public function hasFolder(): bool;

    public function getFolder(): ?FolderInterface;

    public function setFolder(?FolderInterface $folder): void;

    public function hasDstFile(): bool;

    public function getDstFile(): ?FileInterface;

    public function setDstFile(?FileInterface $dstFile): void;

    public function hasTestAlbum(): bool;

    public function getTestAlbum(): ?AlbumInterface;

    public function setTestAlbum(?AlbumInterface $testAlbum): void;

    public function isMarkedAsSpam(): bool;

    public function getMarkedAsSpamBy(): ?UserInterface;

    public function setMarkedAsSpamBy(?UserInterface $markedAsSpamBy): void;
}