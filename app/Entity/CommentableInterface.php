<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface CommentableInterface
{
    public function getComments(): Collection;

    public function hasComment(CommentInterface $comment): bool;

    public function getImages(): Collection;

    public function addImage(OrderImageInterface $orderImage): void;

    public function removeImage(OrderImageInterface $orderImage): void;

    public function addComment(CommentInterface $comment): void;

    public function removeComment(CommentInterface $comment): void;
}