<?php

declare(strict_types=1);

namespace App\Entity;

interface ImageInterface extends
    ResourceInterface,
    NameableInterface,
    UserAwareInterface,
    TimestampableInterface
{
    public function hasAlbum(): bool;

    public function getAlbum(): ?AlbumInterface;

    public function setAlbum(?AlbumInterface $album): void;

    public function getPath(): ?string;

    public function setPath(?string $path): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}