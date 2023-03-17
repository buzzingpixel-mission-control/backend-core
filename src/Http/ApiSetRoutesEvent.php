<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use MissionControlBackend\Events\StoppableEvent;
use Slim\Interfaces\RouteCollectorProxyInterface;

class ApiSetRoutesEvent extends StoppableEvent
{
    public function __construct(
        public readonly RouteCollectorProxyInterface $routeCollector,
    ) {
    }
}
