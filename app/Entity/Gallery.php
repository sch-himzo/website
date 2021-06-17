<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="gallery")
 */
class Gallery implements GalleryInterface
{
    use ResourceTrait;
    use NameableTrait;
    use TimestampableTrait;
    use RoleAwareTrait;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $description = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Album", mappedBy="gallery")
     */
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function hasAlbums(): bool
    {
        return !$this->albums->isEmpty();
    }

    public function hasAlbum(AlbumInterface $album): bool
    {
        return $this->albums->contains($album);
    }

    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(AlbumInterface $album): void
    {
        if (!$this->hasAlbum($album)) {
            $this->albums->add($album);
            $album->setGallery($this);
        }
    }

    public function removeAlbum(AlbumInterface $album): void
    {
        if ($this->hasAlbum($album)) {
            $this->albums->removeElement($album);
            $album->setGallery(null);
        }
    }

    public function removeAlbums(): void
    {
        foreach ($this->albums as $album) {
            $this->removeAlbum($album);
        }
    }

    public function getImages(): Collection
    {
        $images = new ArrayCollection();

        /** @var AlbumInterface $album */
        foreach ($this->albums as $album) {

            /** @var ImageInterface $image */
            foreach ($album->getImages() as $image) {

                if (!$images->contains($image)) {
                    $images->add($image);
                }
            }
        }

        return $images;
    }
}