<?php

declare(strict_types=1);

namespace MissionControlBackend;

use MissionControlBackend\Cli\BootCliCommands;
use MissionControlBackend\Http\BootHttpRoutes;
use MissionControlBackend\Http\SlimHelpers\MissionControlCallableResolver;
use Psr\Container\ContainerInterface;
use Silly\Application;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

use function assert;

readonly class BootApplication
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function buildHttpApplication(): BootHttpRoutes
    {
        $callableResolver = $this->container->get(
            MissionControlCallableResolver::class,
        );

        assert(
            $callableResolver instanceof MissionControlCallableResolver,
        );

        $app = AppFactory::create(
            container: $this->container,
            callableResolver: $callableResolver,
        );

        $request = ServerRequestCreatorFactory::create()
            ->createServerRequestFromGlobals();

        return new BootHttpRoutes(
            app: $app,
            request: $request,
        );
    }

    public function buildCliApplication(): BootCliCommands
    {
        $app = $this->container->get(Application::class);

        assert($app instanceof Application);

        $app->useContainer(container: $this->container);

        $bootCliCommands = $this->container->get(BootCliCommands::class);

        assert($bootCliCommands instanceof BootCliCommands);

        return $bootCliCommands;
    }
}
