<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use MissionControlBackend\CoreConfig;
use MissionControlBackend\Http\ErrorHandling\HttpErrorAction;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

use function assert;

readonly class BootHttpErrorHandling
{
    public function __construct(
        private App $app,
        private CoreConfig $config,
        private ServerRequestInterface $request,
    ) {
    }

    public function registerErrorHandling(): BootHttpMiddleware
    {
        $bootHttpMiddleware = new BootHttpMiddleware(
            app: $this->app,
            request: $this->request,
        );

        if ($this->config->devMode) {
            return $bootHttpMiddleware;
        }

        $errorMiddleware = $this->app->addErrorMiddleware(
            displayErrorDetails: false,
            logErrors: false,
            logErrorDetails: false,
        );

        /** @phpstan-ignore-next-line */
        $httpErrorAction = $this->app->getContainer()->get(
            HttpErrorAction::class,
        );

        assert($httpErrorAction instanceof HttpErrorAction);

        $errorMiddleware->setDefaultErrorHandler(
            handler: $httpErrorAction,
        );

        return $bootHttpMiddleware;
    }
}
