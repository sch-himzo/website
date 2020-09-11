<?php

declare(strict_types=1);

namespace App\Entities\Gallery;

use App\Entities\User\UserInterface;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use App\Traits\UserAwareTrait;
use DateTimeInterface;

class Image implements ImageInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use UserAwareTrait;

    /** @var string */
    private $image;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var AlbumInterface|null */
    private $album;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getAlbum(): ?AlbumInterface
    {
        return $this->album;
    }

    public function setAlbum(?AlbumInterface $album): void
    {
        $this->album = $album;
    }

    public function hasAlbum(): bool
    {
        return isset($this->album);
    }
}
