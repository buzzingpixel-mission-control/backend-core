<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;

use function assert;

readonly class Run
{
    public function __construct(private App $app)
    {
    }

    public function runApplication(
        ServerRequestInterface|null $request = null,
    ): void {
        /** @phpstan-ignore-next-line */
        $responseEmitter = $this->app->getContainer()->get(
            ResponseEmitter::class,
        );

        assert($responseEmitter instanceof ResponseEmitter);

        $request ??= ServerRequestCreatorFactory::create()
            ->createServerRequestFromGlobals();

        $responseEmitter->emit($this->app->handle($request));
    }
}
