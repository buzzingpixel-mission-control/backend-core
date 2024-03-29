<?php

declare(strict_types=1);

namespace MissionControlBackend\Cli;

use MissionControlBackend\CoreConfig;
use MissionControlBackend\ErrorLogging\ErrorLogFactory;
use MissionControlBackend\ErrorLogging\SaveErrorLogFactory;
use Psr\EventDispatcher\EventDispatcherInterface;
use Silly\Application;

readonly class BootCommands
{
    public function __construct(
        private Application $app,
        private CoreConfig $coreConfig,
        private ErrorLogFactory $errorLogFactory,
        private SaveErrorLogFactory $saveErrorLogFactory,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function applyCommands(): Run
    {
        $this->eventDispatcher->dispatch(new ApplyCliCommandsEvent(
            $this->app,
        ));

        return new Run(
            $this->app,
            $this->coreConfig,
            $this->errorLogFactory,
            $this->saveErrorLogFactory,
        );
    }
}
