<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="color")
 */
class Color implements ColorInterface
{
    use ResourceTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string")
     */
    private string $type = self::TYPE_ISACORD;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\File", inversedBy="colors")
     * @ORM\JoinColumn(name="file_id", nullable=true)
     */
    private ?FileInterface $file = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $number = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $color = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $code = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $stitchCount = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $fancy = false;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type ?? self::TYPE_ISACORD;
    }

    public function hasFile(): bool
    {
        return isset($this->file);
    }

    public function getFile(): ?FileInterface
    {
        return $this->file;
    }

    public function setFile(?FileInterface $file): void
    {
        $this->file = $file;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color)
    {
        $this->color = $color;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getStitchCount(): ?int
    {
        return $this->stitchCount;
    }

    public function setStitchCount(?int $stitchCount): void
    {
        $this->stitchCount = $stitchCount;
    }

    public function isFancy(): bool
    {
        return $this->fancy;
    }

    public function setFancy(bool $fancy): void
    {
        $this->fancy = $fancy;
    }
}