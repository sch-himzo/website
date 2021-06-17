<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="setting")
 */
class Setting implements SettingInterface
{
    use ResourceTrait;
    use NameableTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $setting = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $description = null;

    public function getSetting(): ?string
    {
        return $this->setting;
    }

    public function setSetting(?string $setting): void
    {
        $this->setting = $setting;
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