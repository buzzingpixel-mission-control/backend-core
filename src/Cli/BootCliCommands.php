<?php

declare(strict_types=1);

namespace MissionControlBackend\Cli;

use Psr\EventDispatcher\EventDispatcherInterface;
use Silly\Application;

readonly class BootCliCommands
{
    public function __construct(
        private Application $app,
        private BootCliRun $bootCliRun,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function applyCommands(): BootCliRun
    {
        $this->eventDispatcher->dispatch(event: new ApplyCliCommandsEvent(
            app: $this->app,
        ));

        return $this->bootCliRun;
    }
}
