<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait RoleAwareTrait
{
    /**
     * @ORM\ManyToOne(targetEntity=App\Entity\Role)
     * @ORM\JoinColumn(name=role_id, nullable=true)
     */
    private ?RoleInterface $role;

    public function getRole(): ?RoleInterface
    {
        return $this->role;
    }

    public function setRole(RoleInterface $role): void
    {
        $this->role = $role;
    }
}