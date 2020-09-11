<?php

declare(strict_types=1);

namespace App\Entities\Order;

use App\Traits\DeletableInterface;
use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;

interface OrderImageInterface extends EntityInterface, TimestampableInterface, DeletableInterface
{
    public function getImage(): ?string;

    public function setImage(?string $image): void;

    public function getOrderItem(): ?OrderItemInterface;

    public function setOrderItem(?OrderItemInterface $orderItem): void;
}
