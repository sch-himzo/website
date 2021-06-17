<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\RoleInterface;

interface RoleFactoryInterface
{
    public function createNamed(string $name): RoleInterface;
}