<?php

declare(strict_types=1);

namespace App\Entities\Gallery;

use App\Entities\User\RoleInterface;
use App\Traits\EntityTrait;
use App\Traits\RoleAwareTrait;
use App\Traits\TimestampableTrait;
use App\Traits\UserAwareTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Album implements AlbumInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use RoleAwareTrait;

    /** @var GalleryInterface|null */
    private $gallery;

    /** @var string */
    private $name;

    /** @var ArrayCollection|ImageInterface[] */
    private $images;

    public function getGallery(): GalleryInterface
    {
        return $this->gallery;
    }

    public function setGallery(GalleryInterface $gallery): void
    {
        $this->gallery = $gallery;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getImages(): ArrayCollection
    {
        return $this->images;
    }

    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function addImage(ImageInterface $image): void
    {
        if(!$this->hasImage($image)) {
            $this->images->add($image);
        }
    }

    public function removeImage(ImageInterface $image): void
    {
        if($this->hasImage($image)) {
            $this->images->removeElement($image);
        }
    }

    public function removeImages(): void
    {
        $this->images->clear();
    }
}
