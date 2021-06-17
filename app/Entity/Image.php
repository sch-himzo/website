<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image implements ImageInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use NameableTrait;
    use UserAwareTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="images")
     * @ORM\JoinColumn(name="album_id", nullable=true)
     */
    private ?AlbumInterface $album = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $path = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $description = null;

    public function hasAlbum(): bool
    {
        return isset($this->album);
    }

    public function getAlbum(): ?AlbumInterface
    {
        return $this->album;
    }

    public function setAlbum(?AlbumInterface $album): void
    {
        $this->album = $album;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}