<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Fixture\CompositeFixture;
use Illuminate\Console\Command;

class RunFixtures extends Command
{
    protected $signature = 'himzo:fixtures:run';

    protected $description = 'Run model fixtures';

    private CompositeFixture $fixtureRegistry;

    public function __construct(
        CompositeFixture $fixtureRegistry
    ){
        parent::__construct();

        $this->fixtureRegistry = $fixtureRegistry;
    }

    public function handle(): int
    {
        try {
            foreach ($this->fixtureRegistry->getFixtures() as $fixture) {
                $this->output->info(sprintf('Running fixture \'%s\'.', $fixture->getName()));

                $start = microtime(true);

                $fixture->run();

                $end = microtime(true);

                $runTime = round($end - $start, 3);

                $this->output->success(sprintf('Success! [%ss]', $runTime));
            }

            return self::SUCCESS;
        } catch (\Exception $exception) {
            $this->output->error($exception->getMessage());
        }

        return self::FAILURE;
    }
}
