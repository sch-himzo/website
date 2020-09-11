<?php

declare(strict_types=1);

namespace App\Entities\Gallery;

use App\Entities\User\RoleInterface;
use App\Traits\EntityTrait;
use App\Traits\RoleAwareTrait;
use App\Traits\TimestampableTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Gallery implements GalleryInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use RoleAwareTrait;

    /** @var string */
    private $name;

    /** @var string; */
    private $description;

    /** @var ArrayCollection|AlbumInterface[] */
    private $albums;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getAlbums(): ArrayCollection
    {
        return $this->albums;
    }

    public function hasAlbum(AlbumInterface $album): bool
    {
        return $this->albums->contains($album);
    }

    public function hasAlbums(): bool
    {
        return !$this->albums->isEmpty();
    }

    public function addAlbum(AlbumInterface $album): void
    {
        if(!$this->hasAlbum($album)) {
            $this->albums->add($album);
        }
    }

    public function removeAlbum(AlbumInterface $album): void
    {
        if($this->hasAlbum($album)) {
            $this->albums->removeElement($album);
        }
    }

    public function removeAlbums(): void
    {
        $this->albums->clear();
    }
}
