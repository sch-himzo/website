<?php

declare(strict_types=1);

namespace App\Entity;

interface CommentInterface extends
    ResourceInterface,
    UserAwareInterface,
    TimestampableInterface,
    OrderAwareInterface
{
    public function hasCommentable(): bool;

    public function getCommentable(): ?CommentableInterface;

    public function setCommentable(?CommentableInterface $commentable): void;

    public function getComment(): ?string;

    public function setComment(?string $comment): void;
}