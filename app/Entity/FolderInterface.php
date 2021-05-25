<?php

declare(strict_types=1);

namespace App\Entity;

interface FolderInterface extends
    ResourceInterface,
    TimestampableInterface,
    NameableInterface,
    DeletableInterface
{
    public function hasParent(): bool;

    public function getParent(): ?FolderInterface;

    public function setParent(?FolderInterface $folder): void;

    public function hasOwner(): bool;

    public function getOwner(): ?UserInterface;

    public function setOwner(?UserInterface $user): void;
}