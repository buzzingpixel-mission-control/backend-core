<?php

declare(strict_types=1);

namespace MissionControlBackend\Cli;

use Silly\Application;

readonly class Run
{
    public function __construct(private Application $app)
    {
    }

    public function runApplication(): void
    {
        $this->app->run();
    }
}
