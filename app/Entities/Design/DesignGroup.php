<?php

declare(strict_types=1);

namespace App\Entities\Design;

use App\Traits\DeletableTrait;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use App\Traits\UserAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;

class DesignGroup implements DesignGroupInterface
{
    use EntityTrait;
    use TimestampableTrait;
    use UserAwareTrait;
    use DeletableTrait;

    /** @var string */
    private $name;

    /** @var DesignGroupInterface|null */
    private $parent;

    /** @var ArrayCollection|DesignGroupInterface[] */
    private $children;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getParent(): ?DesignGroupInterface
    {
        return $this->parent;
    }

    public function setParent(?DesignGroupInterface $designGroup): void
    {
        if($designGroup !== $this->parent && !$this->hasChild($designGroup)) {
            $this->parent = $designGroup;
        }
    }

    public function hasParent(): bool
    {
        return isset($this->parent);
    }

    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    public function hasChild(DesignGroupInterface $designGroup): bool
    {
        if(!$this->hasChildren()) {
            return false;
        }

        if($this->children->contains($designGroup)) {
            return true;
        }

        $hasChild = false;

        /** @var DesignGroupInterface $child */
        foreach($this->children as $child) {
            if($hasChild = $child->hasChild($designGroup)) {
                break;
            }
        }

        return $hasChild;
    }

    public function hasChildNonRecursive(DesignGroupInterface $designGroup): bool
    {
        return $this->children->contains($designGroup);
    }

    public function hasChildren(): bool
    {
        return !$this->children->isEmpty();
    }

    public function addChild(DesignGroupInterface $designGroup): void
    {
        if(!$this->hasChild($designGroup)) {
            $this->children->add($designGroup);
        }
    }

    public function removeChild(DesignGroupInterface $designGroup): void
    {
        if($this->hasChildNonRecursive($designGroup)) {
            $this->children->remove($designGroup);
        }
    }

    public function removeChildren(): void
    {
        $this->children->clear();
    }
}
