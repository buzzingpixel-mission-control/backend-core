<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\ResponseEmitter;

use function assert;

readonly class BootEmitResponse
{
    public function __construct(
        private App $app,
        private ServerRequestInterface $request,
    ) {
    }

    public function emitResponse(): void
    {
        $response = $this->app->handle(request: $this->request);

        /** @phpstan-ignore-next-line */
        $responseEmitter = $this->app->getContainer()->get(
            ResponseEmitter::class,
        );

        assert($responseEmitter instanceof ResponseEmitter);

        $responseEmitter->emit(response: $response);
    }
}
