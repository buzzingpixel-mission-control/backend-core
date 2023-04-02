<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Slim\App;

use function assert;
use function is_string;

readonly class BootHttpMiddleware
{
    public function __construct(
        private App $app,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function applyMiddleware(
        BootHttpMiddlewareConfig $config,
    ): Run {
        if ($config->useProductionErrorMiddleware) {
            $this->applyProductionErrorMiddleware($config);
        }

        $this->eventDispatcher->dispatch(new ApplyMiddlewareEvent(
            $this->app,
        ));

        return new Run($this->app);
    }

    private function applyProductionErrorMiddleware(
        BootHttpMiddlewareConfig $config,
    ): void {
        $logger = $config->productionErrorMiddlewareLogger;

        if (is_string($logger)) {
            $logger = $this->app->getContainer()?->get($logger);
            assert($logger instanceof LoggerInterface);
        }

        $errorMiddleware = $this->app->addErrorMiddleware(
            false,
            false,
            false,
            $logger,
        );

        if ($config->customProductionErrorMiddlewareHandler === null) {
            return;
        }

        $errorMiddleware->setDefaultErrorHandler(
            $config->customProductionErrorMiddlewareHandler,
        );
    }
}
