<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="background")
 */
class Background implements BackgroundInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use NameableTrait;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $code = null;

    /**
     * @ORM\Column(type="array")
     */
    private ?array $colors = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getColor(string $component): ?int
    {
        return isset($this->colors) ? ($this->colors[$component] ?? null) : null;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function setColor(string $component, int $value): void
    {
        if (in_array($component, self::COLOR_COMPONENT_MAP)) {
            $this->colors[$component] = $value;
        }
    }

    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }
}