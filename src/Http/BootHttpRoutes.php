<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use MissionControlBackend\CoreConfig;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

use function assert;

readonly class BootHttpRoutes
{
    public function __construct(
        private App $app,
        private ServerRequestInterface $request,
    ) {
    }

    public function applyRoutes(
        HttpRoutesConfig $routesConfig,
    ): BootHttpErrorHandling {
        $request = $this->request;

        $currentServerHost = $request->getHeader(
            'HTTP_X_FORWARDED_HOST',
        )[0] ?? null;

        if ($currentServerHost === null) {
            $currentServerHost = $request->getHeader('HOST')[0] ?? null;
        }

        /** @phpstan-ignore-next-line */
        $eventDispatcher = $this->app->getContainer()->get(
            EventDispatcherInterface::class,
        );

        assert($eventDispatcher instanceof EventDispatcherInterface);

        $eventDispatcher->dispatch(event: match ($currentServerHost) {
            $routesConfig->authHost => new AuthSetRoutesEvent(
                routeCollector: $this->app,
            ),
            $routesConfig->accountHost => new AccountSetRoutesEvent(
                routeCollector: $this->app,
            ),
            default => new ApiSetRoutesEvent(
                routeCollector: $this->app,
            ),
        });

        /** @phpstan-ignore-next-line */
        $config = $this->app->getContainer()->get(CoreConfig::class);

        assert($config instanceof CoreConfig);

        return new BootHttpErrorHandling(
            app: $this->app,
            config: $config,
            request: $this->request,
        );
    }
}
