<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Entities\Order\OrderInterface;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TemporaryUser implements TemporaryUserInterface
{
    use EntityTrait;
    use TimestampableTrait;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var ArrayCollection|OrderInterface[] */
    private $orders;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    public function hasOrder(OrderInterface $order): bool
    {
        return $this->orders->contains($order);
    }

    public function hasOrders(): bool
    {
        return !$this->orders->isEmpty();
    }

    public function addOrder(OrderInterface $order): void
    {
        if(!$this->hasOrder($order)) {
            $this->orders->add($order);
        }
    }

    public function removeOrder(OrderInterface $order): void
    {
        if($this->hasOrder($order)) {
            $this->orders->removeElement($order);
        }
    }

    public function removeOrders(): void
    {
        $this->orders->clear();
    }
}
