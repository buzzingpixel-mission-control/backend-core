<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

use function assert;

readonly class BootHttpMiddleware
{
    public function __construct(
        private App $app,
        private ServerRequestInterface $request,
    ) {
    }

    public function registerHttpMiddleware(): BootEmitResponse
    {
        /** @phpstan-ignore-next-line */
        $eventDispatcher = $this->app->getContainer()->get(
            EventDispatcherInterface::class,
        );

        assert($eventDispatcher instanceof EventDispatcherInterface);

        $eventDispatcher->dispatch(event: new SetMiddlewareEvent(
            app: $this->app,
        ));

        return new BootEmitResponse(
            app: $this->app,
            request: $this->request,
        );
    }
}
