<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Setting;
use App\Entity\SettingInterface;

class SettingFactory implements SettingFactoryInterface
{
    public function createNew(): SettingInterface
    {
        return new Setting();
    }

    public function createNamed(string $name): SettingInterface
    {
        $setting = $this->createNew();

        $setting->setName($name);

        return $setting;
    }
}