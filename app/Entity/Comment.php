<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment implements CommentInterface
{
    use ResourceTrait;
    use UserAwareTrait;
    use TimestampableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="comments")
     * @ORM\JoinColumn(name="order_id", nullable=true)
     */
    private ?OrderInterface $order = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrderItem", inversedBy="comments")
     * @ORM\JoinColumn(name="order_item_id", nullable=true)
     */
    private ?OrderItemInterface $orderItem = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $comment = null;

    public function getOrder(): ?OrderInterface
    {
        throw new \LogicException('Use getCommentable()');
    }

    public function setOrder(?OrderInterface $order): void
    {
        throw new \LogicException('Use setCommentable()');
    }

    public function hasOrder(): bool
    {
        throw new \LogicException('Use hasCommentable()');
    }

    public function setCommentable(?CommentableInterface $commentable): void
    {
        if ($commentable instanceof OrderInterface) {
            $this->order = $commentable;
        } elseif ($commentable instanceof OrderItemInterface) {
            $this->orderItem = $commentable;
        } else {
            throw new \LogicException('Not implemented!');
        }
    }

    public function getCommentable(): ?CommentableInterface
    {
        if (isset($this->order)) {
            return $this->order;
        }

        if (isset($this->orderItem)) {
            return $this->orderItem;
        }

        return null;
    }

    public function hasCommentable(): bool
    {
        return isset($this->orderItem) || isset($this->order);
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
}