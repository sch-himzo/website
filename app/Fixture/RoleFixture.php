<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Factory\RoleFactory;
use App\Factory\RoleFactoryInterface;
use App\Util\Roles;
use Doctrine\ORM\EntityManagerInterface;

class RoleFixture extends AbstractFixture
{
    private EntityManagerInterface $entityManager;

    private RoleFactory $roleFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        RoleFactory $roleFactory
    ) {
        $this->entityManager = $entityManager;
        $this->roleFactory = $roleFactory;
    }

    public function run(): void
    {
        foreach (Roles::ROLE_MAP as $description => $name) {
            $role = $this->roleFactory->createNamed($name);

            $role->setDescription($description);

            $this->entityManager->persist($role);
        }

        $this->entityManager->flush();
    }

    public function getName(): string
    {
        return 'role';
    }
}