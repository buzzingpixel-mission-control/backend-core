<?php

declare(strict_types=1);

namespace MissionControlBackend\Cli;

use Silly\Application;

readonly class BootCliRun
{
    public function __construct(private Application $app)
    {
    }

    public function run(): void
    {
        $this->app->run();
    }
}
