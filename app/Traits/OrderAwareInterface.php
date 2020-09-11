<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\Order\OrderInterface;

interface OrderAwareInterface
{
    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order): void;

    public function hasOrder(): bool;
}
