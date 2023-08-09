<?php

declare(strict_types=1);

namespace MissionControlBackend;

use MissionControlBackend\Cli\BootCommands;
use MissionControlBackend\ErrorLogging\ErrorLogFactory;
use MissionControlBackend\ErrorLogging\SaveErrorLogFactory;
use MissionControlBackend\Http\BootHttpRoutes;
use MissionControlBackend\Http\SlimHelpers\MissionControlCallableResolver;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Silly\Application;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

use function assert;

readonly class BootApplication
{
    public function __construct(
        private CoreConfig $coreConfig,
        private ContainerInterface $container,
        private EventDispatcherInterface $eventDispatcher,
        private MissionControlCallableResolver $callableResolver,
    ) {
    }

    public function buildHttpApplication(
        ServerRequestInterface|null $request = null,
    ): BootHttpRoutes {
        $app = AppFactory::create(
            container: $this->container,
            callableResolver: $this->callableResolver,
        );

        $request ??= ServerRequestCreatorFactory::create()
            ->createServerRequestFromGlobals();

        return new BootHttpRoutes(
            $app,
            $this->coreConfig,
            $request,
            $this->eventDispatcher,
        );
    }

    public function buildCliApplication(): BootCommands
    {
        $app = new Application('MissionControl Backend CLI');

        $app->useContainer(container: $this->container);

        $errorLogFactory = $this->container->get(ErrorLogFactory::class);
        assert($errorLogFactory instanceof ErrorLogFactory);

        $saveErrorLogFactory = $this->container->get(SaveErrorLogFactory::class);
        assert($saveErrorLogFactory instanceof SaveErrorLogFactory);

        return new BootCommands(
            $app,
            $this->coreConfig,
            $errorLogFactory,
            $saveErrorLogFactory,
            $this->eventDispatcher,
        );
    }
}
