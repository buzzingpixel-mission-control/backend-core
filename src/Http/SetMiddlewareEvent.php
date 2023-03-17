<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use MissionControlBackend\Events\StoppableEvent;
use Slim\App;

class SetMiddlewareEvent extends StoppableEvent
{
    public function __construct(public readonly App $app)
    {
    }
}
