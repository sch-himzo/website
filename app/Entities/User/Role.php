<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Role implements RoleInterface
{
    use EntityTrait;
    use TimestampableTrait;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var ArrayCollection|UserInterface[] */
    private $users;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    public function hasUser(UserInterface $user): bool
    {
        return $this->users->contains($user);
    }

    public function addUser(UserInterface $user): void
    {
        if(!$this->hasUser($user)) {
            $this->users->add($user);
        }
    }

    public function removeUser(UserInterface $user): void
    {
        if($this->hasUser($user)) {
            $this->users->removeElement($user);
        }
    }

    public function removeUsers(): void
    {
        $this->users->clear();
    }
}
