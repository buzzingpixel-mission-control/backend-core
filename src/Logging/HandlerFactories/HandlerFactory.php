<?php

declare(strict_types=1);

namespace MissionControlBackend\Logging\HandlerFactories;

use Monolog\Handler\HandlerInterface;

interface HandlerFactory
{
    public function create(): HandlerInterface;
}
