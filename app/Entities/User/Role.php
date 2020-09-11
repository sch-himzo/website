<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Entities\Gallery\AlbumInterface;
use App\Entities\Gallery\GalleryInterface;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Role implements RoleInterface
{
    use EntityTrait;
    use TimestampableTrait;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var ArrayCollection|AlbumInterface[] */
    private $albums;

    /** @var ArrayCollection|UserInterface[] */
    private $users;

    /** @var ArrayCollection|GalleryInterface[] */
    private $galleries;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    public function hasUser(UserInterface $user): bool
    {
        return $this->users->contains($user);
    }

    public function addUser(UserInterface $user): void
    {
        if(!$this->hasUser($user)) {
            $this->users->add($user);
        }
    }

    public function removeUser(UserInterface $user): void
    {
        if($this->hasUser($user)) {
            $this->users->removeElement($user);
        }
    }

    public function removeUsers(): void
    {
        $this->users->clear();
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

    public function getGalleries(): ArrayCollection
    {
        return $this->galleries;
    }

    public function hasGallery(GalleryInterface $gallery): bool
    {
        return $this->galleries->contains($gallery);
    }

    public function hasGalleries(): bool
    {
        return !$this->galleries->isEmpty();
    }

    public function addGallery(GalleryInterface $gallery): void
    {
        if(!$this->hasGallery($gallery)) {
            $this->galleries->add($gallery);
        }
    }

    public function removeGallery(GalleryInterface $gallery): void
    {
        if($this->hasGallery($gallery)) {
            $this->galleries->removeElement($gallery);
        }
    }

    public function removeGalleries(): void
    {
        $this->galleries->clear();
    }
}
