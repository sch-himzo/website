<?php

declare(strict_types=1);

namespace App\Entities\Design;

use App\Traits\DeletableInterface;
use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;
use App\Traits\UserAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface DesignGroupInterface extends
    EntityInterface,
    TimestampableInterface,
    UserAwareInterface,
    DeletableInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getParent(): ?DesignGroupInterface;

    public function setParent(?DesignGroupInterface $designGroup): void;

    public function hasParent(): bool;

    public function getChildren(): ArrayCollection;

    public function hasChild(DesignGroupInterface $designGroup): bool;

    public function hasChildNonRecursive(DesignGroupInterface $designGroup): bool;

    public function hasChildren(): bool;

    public function addChild(DesignGroupInterface $designGroup): void;

    public function removeChild(DesignGroupInterface $designGroup): void;

    public function removeChildren(): void;
}
