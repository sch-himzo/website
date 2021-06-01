<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="folder")
 */
class Folder implements FolderInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use NameableTrait;
    use DeletableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Folder")
     * @ORM\JoinColumn(name="parent_id", nullable=true)
     */
    private ?FolderInterface $parent = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="owner_id", nullable=true)
     */
    private ?UserInterface $owner = null;

    public function hasParent(): bool
    {
        return isset($this->parent);
    }

    public function getParent(): ?FolderInterface
    {
        return $this->parent;
    }

    public function setParent(?FolderInterface $folder): void
    {
        $this->parent = $folder;
    }

    public function hasOwner(): bool
    {
        return isset($this->owner);
    }

    public function getOwner(): ?UserInterface
    {
        return $this->owner;
    }

    public function setOwner(?UserInterface $user): void
    {
        $this->owner = $user;
    }
}