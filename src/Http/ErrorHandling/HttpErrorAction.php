<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\ErrorHandling;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

readonly class HttpErrorAction
{
    public function __construct(private ResponderFactory $responderFactory)
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
    ): ResponseInterface {
        return $this->responderFactory->createResponder(
            request: $request,
        )->respond(exception: $exception);
    }
}
