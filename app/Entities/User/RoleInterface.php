<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Entities\Gallery\AlbumInterface;
use App\Entities\Gallery\GalleryInterface;
use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface RoleInterface extends
    EntityInterface,
    TimestampableInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): string;

    public function setDescription(?string $description): void;

    public function getUsers(): ArrayCollection;

    public function addUser(UserInterface $user): void;

    public function removeUser(UserInterface $user): void;

    public function hasUser(UserInterface $user): bool;

    public function removeUsers(): void;

    public function getAlbums(): ArrayCollection;

    public function hasAlbum(AlbumInterface $album): bool;

    public function hasAlbums(): bool;

    public function addAlbum(AlbumInterface $album): void;

    public function removeAlbum(AlbumInterface $album): void;

    public function removeAlbums(): void;

    public function getGalleries(): ArrayCollection;

    public function hasGallery(GalleryInterface $gallery): bool;

    public function hasGalleries(): bool;

    public function addGallery(GalleryInterface $gallery): void;

    public function removeGallery(GalleryInterface $gallery): void;

    public function removeGalleries(): void;
}
