<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use MongoDB\BSON\Timestamp;

interface AlbumInterface extends
    ResourceInterface,
    TimestampableInterface,
    NameableInterface,
    RoleAwareInterface
{
    public function getGallery(): ?GalleryInterface;

    public function setGallery(?GalleryInterface $gallery): void;

    public function hasImages(): bool;

    public function hasImage(ImageInterface $image): bool;

    public function getImages(): Collection;

    public function addImage(ImageInterface $image): void;

    public function removeImage(ImageInterface $image): void;
}