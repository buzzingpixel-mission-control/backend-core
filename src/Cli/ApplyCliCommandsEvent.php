<?php

declare(strict_types=1);

namespace MissionControlBackend\Cli;

use MissionControlBackend\Events\StoppableEvent;
use Silly\Application;

class ApplyCliCommandsEvent extends StoppableEvent
{
    public function __construct(public readonly Application $app)
    {
    }
}
