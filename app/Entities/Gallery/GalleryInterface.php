<?php

declare(strict_types=1);

namespace App\Entities\Gallery;

use App\Traits\EntityInterface;
use App\Traits\RoleAwareInterface;
use App\Traits\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface GalleryInterface extends
    EntityInterface,
    RoleAwareInterface,
    TimestampableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getAlbums(): ArrayCollection;

    public function hasAlbum(AlbumInterface $album): bool;

    public function hasAlbums(): bool;

    public function addAlbum(AlbumInterface $album): void;

    public function removeAlbum(AlbumInterface $album): void;

    public function removeAlbums(): void;
}
