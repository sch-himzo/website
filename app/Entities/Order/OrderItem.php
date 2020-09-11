<?php

declare(strict_types=1);

namespace App\Entities\Order;

use App\Entities\Design\DesignGroupInterface;
use App\Entities\Gallery\AlbumInterface;
use App\Entities\User\UserInterface;
use App\Traits\DeletableTrait;
use App\Traits\EntityTrait;
use App\Traits\OrderAwareTrait;
use App\Traits\TimestampableTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class OrderItem implements OrderItemInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use OrderAwareTrait;
    use DeletableTrait;

    const TYPE_BADGE = 'badge';
    const TYPE_SHIRT = 'shirt';
    const TYPE_JUMPER = 'jumper';

    const TYPE_MAP = [
        self::TYPE_BADGE => 'Folt',
        self::TYPE_SHIRT => 'Póló',
        self::TYPE_JUMPER => 'Pulcsi'
    ];

    const STATUS_NEW = 'new';
    const STATUS_DESIGNED = 'designed';
    const STATUS_TESTED = 'tested';
    const STATUS_EMBROIDERED = 'embroidered';
    const STATUS_PAID = 'paid';
    const STATUS_DONE = 'done';

    const STATUS_MAP = [
        self::STATUS_NEW => 'Beérkezett',
        self::STATUS_DESIGNED => 'Tervezve',
        self::STATUS_TESTED => 'Próbahímzés kész',
        self::STATUS_EMBROIDERED => 'Hímezve',
        self::STATUS_PAID => 'Fizetve',
        self::STATUS_DONE => 'Átadva'
    ];

    /** @var string */
    private $title;

    /** @var int */
    private $amount;

    /** @var DateTimeInterface|null */
    private $timeLimit;

    /** @var string */
    private $type;

    /** @var string */
    private $size;

    /** @var string */
    private $status;

    /** @var string */
    private $font;

    /** @var string */
    private $comment;

    /** @var bool */
    private $existingDesign;

    /** @var float */
    private $finalDiameter;

    /** @var DesignGroupInterface|null */
    private $designGroup;

    /** @var AlbumInterface|null */
    private $testAlbum;

    /** @var bool */
    private $markedSpam;

    /** @var UserInterface */
    private $markedBy;

    /** @var ArrayCollection|OrderImageInterface[] */
    private $images;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getTimeLimit(): ?DateTimeInterface
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(?DateTimeInterface $timeLimit): void
    {
        $this->timeLimit = $timeLimit;
    }

    public function hasTimeLimit(): bool
    {
        return isset($this->timeLimit);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        if(array_key_exists($type, self::TYPE_MAP)) {
            $this->type = $type;
        }
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(?string $font): void
    {
        $this->font = $font;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        if(array_key_exists($status, self::STATUS_MAP)) {
            $this->status = $status;
        }
    }

    public function isExistingDesign(): bool
    {
        return $this->existingDesign;
    }

    public function setExistingDesign(bool $existingDesign): void
    {
        $this->existingDesign = $existingDesign;
    }

    public function getFinalDiameter(): ?float
    {
        return $this->finalDiameter;
    }

    public function setFinalDiameter(?float $finalDiameter): void
    {
        $this->finalDiameter = $finalDiameter;
    }

    public function getDesignGroup(): ?DesignGroupInterface
    {
        return $this->designGroup;
    }

    public function setDesignGroup(?DesignGroupInterface $designGroup): void
    {
        $this->designGroup = $designGroup;
    }

    public function hasDesignGroup(): bool
    {
        return isset($this->designGroup);
    }

    public function getTestAlbum(): ?AlbumInterface
    {
        return $this->testAlbum;
    }

    public function setTestAlbum(?AlbumInterface $album): void
    {
        $this->testAlbum = $album;
    }

    public function hasTestAlbum(): bool
    {
        return isset($this->testAlbum);
    }

    public function isMarkedSpam(): bool
    {
        return $this->markedSpam;
    }

    public function setMarkedSpam(bool $markedSpam): void
    {
        $this->markedSpam = $markedSpam;
    }

    public function getMarkedBy(): ?UserInterface
    {
        return $this->markedBy;
    }

    public function setMarkedBy(?UserInterface $markedBy): void
    {
        $this->markedBy = $markedBy;
    }

    public function hasMarkedBy(): bool
    {
        return isset($this->markedBy);
    }

    public function getImages(): ArrayCollection
    {
        return $this->images;
    }

    public function hasImage(OrderImageInterface $orderImage): bool
    {
        return $this->images->contains($orderImage);
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function addImage(OrderImageInterface $orderImage): void
    {
        if(!$this->hasImage($orderImage)) {
            $this->images->add($orderImage);
        }
    }

    public function removeImage(OrderImageInterface $orderImage): void
    {
        if($this->hasImage($orderImage)) {
            $this->images->removeElement($orderImage);
        }
    }

    public function removeImages(): void
    {
        $this->images->clear();
    }
}
