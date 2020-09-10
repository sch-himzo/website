<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;

interface TemporaryUserInterface extends
    EntityInterface,
    TimestampableInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;
}
