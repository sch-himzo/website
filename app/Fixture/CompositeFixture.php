<?php

declare(strict_types=1);

namespace App\Fixture;

final class CompositeFixture extends AbstractFixture
{
    /** @var array|AbstractFixture[] */
    private array $fixtures = [];

    public function __construct(
        RoleFixture $roleFixture
    ){
        $this->fixtures[] = $roleFixture;
    }

    public function run(): void
    {
        foreach ($this->fixtures as $fixture) {
            $fixture->run();
        }
    }

    public function getFixtures(): array
    {
        return $this->fixtures;
    }

    public function getName(): string
    {
        return 'composite';
    }
}