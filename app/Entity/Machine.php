<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="machine")
 */
class Machine implements MachineInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use RoleAwareTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $state = self::STATE_END;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $currentStitch = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $stitchCount = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $currentDesign = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $designCount = null;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $stitches = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\File")
     * @ORM\JoinColumn(name="file_id", nullable=true)
     */
    private ?FileInterface $file = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $width = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $height = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $horizontalOffset = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $verticalOffset = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $secondsPassed = null;

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state ?? self::STATE_END;
    }

    public function getCurrentStitch(): ?int
    {
        return $this->currentStitch;
    }

    public function setCurrentStitch(?int $currentStitch): void
    {
        $this->currentStitch = $currentStitch;
    }

    public function getStitchCount(): ?int
    {
        return $this->stitchCount;
    }

    public function setStitchCount(?int $stitchCount)
    {
        $this->stitchCount = $stitchCount;
    }

    public function getCurrentDesign(): ?int
    {
        return $this->currentDesign;
    }

    public function setCurrentDesign(?int $currentDesign)
    {
        $this->currentDesign = $currentDesign;
    }

    public function getDesignCount(): ?int
    {
        return $this->designCount;
    }

    public function setDesignCount(?int $designCount)
    {
        $this->designCount = $designCount;
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

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): void
    {
        $this->height = $height;
    }

    public function getHorizontalOffset(): ?float
    {
        return $this->horizontalOffset;
    }

    public function setHorizontalOffset(?float $horizontalOffset): void
    {
        $this->horizontalOffset = $horizontalOffset;
    }

    public function getVerticalOffset(): ?float
    {
        return $this->verticalOffset;
    }

    public function setVerticalOffset(?float $verticalOffset)
    {
        $this->verticalOffset = $verticalOffset;
    }

    public function getSecondsPassed(): ?int
    {
        return $this->secondsPassed;
    }

    public function setSecondsPassed(?int $secondsPassed): void
    {
        $this->secondsPassed = $secondsPassed;
    }

    public function getStitches(): ?array
    {
        return $this->stitches;
    }

    public function setStitches(?array $stitches): void
    {
        $this->stitches = $stitches;
    }
}