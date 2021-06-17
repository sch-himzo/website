<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class Album implements AlbumInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use RoleAwareTrait;
    use NameableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gallery", inversedBy="albums")
     * @ORM\JoinColumn(name="gallery_id", nullable="true")
     */
    private ?GalleryInterface $gallery = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="album")
     */
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getGallery(): ?GalleryInterface
    {
        return $this->gallery;
    }

    public function setGallery(?GalleryInterface $gallery): void
    {
        $this->gallery = $gallery;
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageInterface $image): void
    {
        if (!$this->hasImage($image)) {
            $this->images->add($image);
            $image->setAlbum($this);
        }
    }

    public function removeImage(ImageInterface $image): void
    {
        if ($this->hasImage($image)) {
            $this->images->removeElement($image);
            $image->setAlbum(null);
        }
    }
}