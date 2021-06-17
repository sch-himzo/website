<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Role;
use App\Entity\RoleInterface;
use App\Util\Roles;

class RoleRepository extends AbstractEntityRepository implements RoleRepositoryInterface
{
    protected function getClass(): string
    {
        return Role::class;
    }

    public function findDefaultRole(): ?RoleInterface
    {
        return $this->findOneBy([
            'name' => Roles::ROLE_DEFAULT
        ]);
    }
}