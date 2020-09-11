<?php

declare(strict_types=1);

namespace App\Entities\Order;

use App\Traits\DeletableTrait;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use DateTimeInterface;

class OrderImage implements OrderImageInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use DeletableTrait;

    /** @var string */
    private $image;

    /** @var OrderItemInterface|null */
    public $orderItem;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getOrderItem(): ?OrderItemInterface
    {
        return $this->orderItem;
    }

    public function setOrderItem(?OrderItemInterface $orderItem): void
    {
        $this->orderItem = $orderItem;
    }
}
