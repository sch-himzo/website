<?php

declare(strict_types=1);

namespace App\Entities\Gallery;

use App\Traits\EntityInterface;
use App\Traits\RoleAwareInterface;
use App\Traits\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface AlbumInterface extends
    EntityInterface,
    TimestampableInterface,
    RoleAwareInterface
{
    public function getGallery(): GalleryInterface;

    public function setGallery(GalleryInterface $gallery): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getImages(): ArrayCollection;

    public function hasImage(ImageInterface $image): bool;

    public function hasImages(): bool;

    public function addImage(ImageInterface $image): void;

    public function removeImage(ImageInterface $image): void;

    public function removeImages(): void;
}
