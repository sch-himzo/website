<?php

declare(strict_types=1);

namespace App\Entity;

interface OrderImageInterface extends
    ResourceInterface,
    TimestampableInterface,
    DeletableInterface
{
    public function getPath(): ?string;

    public function setPath(?string $path): void;

    public function getOrderItem(): ?OrderItemInterface;

    public function setOrderItem(?OrderItemInterface $orderItem): void;
}