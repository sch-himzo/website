<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    public function getGallery(): ?GalleryInterface
    {
        return $this->gallery;
    }

    public function setGallery(?GalleryInterface $gallery): void
    {
        $this->gallery = $gallery;
    }
}