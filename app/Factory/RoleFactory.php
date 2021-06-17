<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Role;
use App\Entity\RoleInterface;

class RoleFactory implements RoleFactoryInterface
{
    public function createNamed(string $name): RoleInterface
    {
        $role = new Role();

        $role->setName($name);

        return $role;
    }
}