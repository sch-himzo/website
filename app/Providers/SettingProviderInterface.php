<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entity\SettingInterface;

interface SettingProviderInterface
{
    public function provide(string $name): SettingInterface;
}