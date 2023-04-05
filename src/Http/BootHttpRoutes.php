<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use MissionControlBackend\CoreConfig;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

readonly class BootHttpRoutes
{
    public function __construct(
        private App $app,
        private CoreConfig $coreConfig,
        private ServerRequestInterface $request,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function applyRoutes(): BootHttpMiddleware
    {
        $request = $this->request;

        $currentServerHost = $request->getHeader(
            'HTTP_X_FORWARDED_HOST',
        )[0] ?? null;

        if ($currentServerHost === null) {
            $currentServerHost = $request->getHeader('HOST')[0] ?? null;
        }

        $this->eventDispatcher->dispatch(match ($currentServerHost) {
            $this->coreConfig->authHost => new AuthApplyRoutesEvent(
                $this->app,
            ),
            $this->coreConfig->accountHost => new AccountApplyRoutesEvent(
                $this->app,
            ),
            default => new ApiApplyRoutesEvent(
                $this->app,
            ),
        });

        return new BootHttpMiddleware(
            $this->app,
            $this->request,
            $this->eventDispatcher,
        );
    }
}
