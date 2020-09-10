<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\User\UserInterface;

trait UserAwareTrait
{
    /** @var UserInterface|null */
    private $user;

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }
}
