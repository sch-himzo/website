<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\Order\OrderInterface;

trait OrderAwareTrait
{
    /** @var OrderInterface|null */
    private $order;

    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function hasOrder(): bool
    {
        return isset($this->order);
    }
}
