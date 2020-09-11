<?php

declare(strict_types=1);

namespace App\Entities\Order;

use App\Entities\User\TemporaryUserInterface;
use App\Entities\User\UserInterface;
use App\Traits\ArchiveableTrait;
use App\Traits\DeletableTrait;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use App\Traits\UserAwareTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Order implements OrderInterface
{
    use EntityTrait;
    use ArchiveableTrait;
    use TimestampableTrait;
    use UserAwareTrait;
    use DeletableTrait;

    /** @var string */
    private $title;

    /** @var bool */
    private $internal;

    /** @var string */
    private $comment;

    /** @var UserInterface|null */
    private $approvedBy;

    /** @var TemporaryUserInterface|null */
    private $temporaryUser;

    /** @var string */
    private $status;

    /** @var bool */
    private $publicAlbums;

    /** @var bool */
    private $jointProject;

    /** @var bool */
    private $helpRequired;

    /** @var DateTimeInterface|null */
    private $timeLimit;

    /** @var DateTimeInterface|null */
    private $eta;

    /** @var bool */
    private $spam;

    /** @var UserInterface|null */
    private $reportedBy;

    /** @var ArrayCollection|OrderItemInterface[] */
    private $items;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function isInternal(): bool
    {
        return $this->internal;
    }

    public function setInternal(bool $internal): void
    {
        $this->internal = $internal;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getApprovedBy(): ?UserInterface
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?UserInterface $user): void
    {
        $this->approvedBy = $user;
    }

    public function getTemporaryUser(): ?TemporaryUserInterface
    {
        return $this->temporaryUser;
    }

    public function setTemporaryUser(?TemporaryUserInterface $temporaryUser): void
    {
        $this->temporaryUser = $temporaryUser;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        if(array_key_exists($status, OrderInterface::STATUS_MAP)) {
            $this->status = $status;
        }
    }

    public function isPublicAlbums(): bool
    {
        return $this->publicAlbums;
    }

    public function setPublicAlbums(bool $publicAlbums): void
    {
        $this->publicAlbums = $publicAlbums;
    }

    public function isJointProject(): bool
    {
        return $this->jointProject;
    }

    public function setJointProject(bool $jointProject): void
    {
        $this->jointProject = $jointProject;
    }

    public function isHelpRequired(): bool
    {
        return $this->helpRequired;
    }

    public function setHelpRequired(bool $helpRequired): void
    {
        $this->helpRequired = $helpRequired;
    }

    public function getTimeLimit(): ?DateTimeInterface
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(?DateTimeInterface $timeLimit): void
    {
        $this->timeLimit = $timeLimit;
    }

    public function getETA(): ?DateTimeInterface
    {
        return $this->eta;
    }

    public function setETA(?DateTimeInterface $eta): void
    {
        $this->eta = $eta;
    }

    public function isSpam(): bool
    {
        return $this->spam;
    }

    public function setSpam(bool $spam): void
    {
        $this->spam = $spam;
    }

    public function getReportedBy(): ?UserInterface
    {
        return $this->reportedBy;
    }

    public function setReportedBy(?UserInterface $reportedBy): void
    {
        $this->reportedBy = $reportedBy;
    }

    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    public function hasItem(OrderItemInterface $orderItem): bool
    {
        return $this->items->contains($orderItem);
    }

    public function hasItems(): bool
    {
        return !$this->items->isEmpty();
    }

    public function addItem(OrderItemInterface $orderItem): void
    {
        if(!$this->hasItem($orderItem)) {
            $this->items->add($orderItem);
        }
    }

    public function removeItem(OrderItemInterface $orderItem): void
    {
        if($this->hasItem($orderItem)) {
            $this->items->removeElement($orderItem);
        }
    }

    public function removeItems(): void
    {
        $this->items->clear();
    }
}
