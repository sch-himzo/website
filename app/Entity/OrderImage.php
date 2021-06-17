<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_image")
 */
class OrderImage implements OrderImageInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use DeletableTrait;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $path = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrderItem", inversedBy="images")
     * @ORM\JoinColumn(name="order_item_id", nullable=true)
     */
    private ?OrderItemInterface $orderItem;

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
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