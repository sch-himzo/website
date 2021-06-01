<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface GalleryInterface extends
    ResourceInterface,
    NameableInterface,
    RoleAwareInterface,
    TimestampableInterface
{
    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function hasAlbums(): bool;

    public function hasAlbum(AlbumInterface $album): bool;

    public function getAlbums(): Collection;

    public function addAlbum(AlbumInterface $album): void;

    public function removeAlbum(AlbumInterface $album): void;

    public function removeAlbums(): void;

    public function getImages(): Collection;
}