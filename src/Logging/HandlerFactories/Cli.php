<?php

declare(strict_types=1);

namespace MissionControlBackend\Logging\HandlerFactories;

use MissionControlBackend\Logging\CustomHandlers\CliLogger;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\PsrHandler;

readonly class Cli implements HandlerFactory
{
    public function __construct(private CliLogger $logger)
    {
    }

    public function create(): HandlerInterface
    {
        return new PsrHandler($this->logger);
    }
}
