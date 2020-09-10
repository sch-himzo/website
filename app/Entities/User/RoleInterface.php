<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface RoleInterface extends
    EntityInterface,
    TimestampableInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): string;

    public function setDescription(?string $description): void;

    public function getUsers(): ArrayCollection;

    public function addUser(UserInterface $user): void;

    public function removeUser(UserInterface $user): void;

    public function hasUser(UserInterface $user): bool;

    public function removeUsers(): void;
}
