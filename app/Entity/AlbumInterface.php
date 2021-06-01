<?php

declare(strict_types=1);

namespace App\Entity;

use MongoDB\BSON\Timestamp;

interface AlbumInterface extends
    ResourceInterface,
    TimestampableInterface,
    NameableInterface,
    RoleAwareInterface
{
    public function getGallery(): ?GalleryInterface;

    public function setGallery(?GalleryInterface $gallery): void;
}