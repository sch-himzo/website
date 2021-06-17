<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entity\UserInterface;
use Doctrine\Common\Collections\Collection;

interface NewsItemProviderInterface
{
    public function provideForUser(UserInterface $user): Collection;
}