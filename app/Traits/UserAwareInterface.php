<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\User\UserInterface;

interface UserAwareInterface
{
    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user): void;
}
