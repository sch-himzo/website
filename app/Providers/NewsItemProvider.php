<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entity\UserInterface;
use App\Repository\NewsItemRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Doctrine\Common\Collections\Collection;

class NewsItemProvider implements NewsItemProviderInterface
{
    private NewsItemRepositoryInterface $newsItemRepository;

    private RoleRepositoryInterface $roleRepository;

    public function __construct(
        NewsItemRepositoryInterface $newsItemRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->newsItemRepository = $newsItemRepository;
        $this->roleRepository = $roleRepository;
    }

    public function provideForUser(?UserInterface $user): Collection
    {
        $role = isset($user) && $user->hasRole() ? $user->getRole() : $this->roleRepository->findDefaultRole();

        return $this->newsItemRepository->findAllViewable($role);
    }
}