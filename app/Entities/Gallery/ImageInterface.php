<?php

declare(strict_types=1);

namespace App\Entities\Gallery;

use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;
use App\Traits\UserAwareInterface;

interface ImageInterface extends
    EntityInterface,
    TimestampableInterface,
    UserAwareInterface
{
    public function getImage(): ?string;

    public function setImage(?string $image): void;

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getAlbum(): ?AlbumInterface;

    public function setAlbum(?AlbumInterface $album): void;

    public function hasAlbum(): bool;
}
