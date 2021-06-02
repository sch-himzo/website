<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class File implements FileInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use DeletableTrait;
    use NameableTrait;

    use OrderAwareTrait {
        getOrder as public getOriginalOrder;
        hasOrder as public hasOriginalOrder;
        setOrder as public setOriginalOrder;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Folder")
     * @ORM\JoinColumn(name="folder_id", nullable=true)
     */
    private ?FolderInterface $folder = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $path = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $colorCount = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $stitchCount = null;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $diameter = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Background")
     * @ORM\JoinColumn(name="background_id", nullable=true)
     */
    private ?BackgroundInterface $background = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $svg = null;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $bytes = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Color", mappedBy="file")
     */
    private Collection $colors;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
    }

    public function hasFolder(): bool
    {
        return isset($this->folder);
    }

    public function getFolder(): ?FolderInterface
    {
        return $this->folder;
    }

    public function setFolder(?FolderInterface $folder): void
    {
        $this->folder = $folder;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getColorCount(): ?int
    {
        return $this->colorCount;
    }

    public function setColorCount(?int $colorCount): void
    {
        $this->colorCount = $colorCount;
    }

    public function getStitchCount(): ?int
    {
        return $this->stitchCount;
    }

    public function setStitchCount(?int $stitchCount): void
    {
        $this->stitchCount = $stitchCount;
    }

    public function getDiameter(): ?float
    {
        return $this->diameter;
    }

    public function setDiameter(?float $diameter): void
    {
        $this->diameter = $diameter;
    }

    public function getBackground(): ?BackgroundInterface
    {
        return $this->background;
    }

    public function setBackground(?BackgroundInterface $background): void
    {
        $this->background = $background;
    }

    public function getSvg(): ?string
    {
        return $this->svg;
    }

    public function setSvg(?string $svg): void
    {
        $this->svg = $svg;
    }

    public function getBytes(): ?string
    {
        return $this->bytes;
    }

    public function setBytes(?string $bytes): void
    {
        $this->bytes = $bytes;
    }

    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function hasColor(ColorInterface $color): bool
    {
        return $this->colors->contains($color);
    }

    public function addColor(ColorInterface $color): void
    {
        if (!$this->hasColor($color)) {
            $this->colors->add($color);
            $color->setFile($this);
        }
    }

    public function removeColor(ColorInterface $color): void
    {
        if ($this->hasColor($color)) {
            $this->colors->removeElement($color);
            $color->setFile(null);
        }
    }
}