<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\SettingInterface;

interface SettingFactoryInterface
{
    public function createNew(): SettingInterface;

    public function createNamed(string $name): SettingInterface;
}