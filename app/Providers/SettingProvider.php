<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entity\Setting;
use App\Entity\SettingInterface;
use App\Factory\SettingFactory;
use App\Factory\SettingFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class SettingProvider implements SettingProviderInterface
{
    private EntityManagerInterface $entityManager;

    private SettingFactoryInterface $settingFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        SettingFactory $settingFactory
    ) {
        $this->entityManager = $entityManager;
        $this->settingFactory = $settingFactory;
    }

    public function provide(string $name): SettingInterface
    {
        $settingRepository = $this->entityManager->getRepository(Setting::class);

        /** @var SettingInterface|null $setting */
        $setting = $settingRepository->findOneBy(['name' => $name]);

        if ($setting === null) {
            return $this->settingFactory->createNamed($name);
        }

        return $setting;
    }
}