<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="news_item")
 */
class NewsItem implements NewsItemInterface
{
    use ResourceTrait;
    use NameableTrait;
    use RoleAwareTrait;
    use TimestampableTrait;
    use UserAwareTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $content = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $alert = false;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function isAlert(): bool
    {
        return $this->alert;
    }

    public function setAlert(bool $alert): void
    {
        $this->alert = $alert;
    }
}