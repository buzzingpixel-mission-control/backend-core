<?php

declare(strict_types=1);

namespace MissionControlBackend;

use MissionControlBackend\Cli\BootCommands;
use MissionControlBackend\Http\BootHttpRoutes;
use MissionControlBackend\Http\SlimHelpers\MissionControlCallableResolver;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Silly\Application;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

readonly class BootApplication
{
    public function __construct(
        private ContainerInterface $container,
        private EventDispatcherInterface $eventDispatcher,
        private MissionControlCallableResolver $callableResolver,
    ) {
    }

    public function buildHttpApplication(): BootHttpRoutes
    {
        $app = AppFactory::create(
            container: $this->container,
            callableResolver: $this->callableResolver,
        );

        $request = ServerRequestCreatorFactory::create()
            ->createServerRequestFromGlobals();

        return new BootHttpRoutes(
            $app,
            $request,
            $this->eventDispatcher,
        );
    }

    public function buildCliApplication(): BootCommands
    {
        $app = new Application('MissionControl Backend CLI');

        $app->useContainer(container: $this->container);

        return new BootCommands(
            $app,
            $this->eventDispatcher,
        );
    }
}
