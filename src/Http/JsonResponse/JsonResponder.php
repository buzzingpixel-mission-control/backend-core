<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\JsonResponse;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

use function json_encode;

readonly class JsonResponder
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function respond(RespondWith $respondWith): ResponseInterface
    {
        $response = $this->responseFactory->createResponse(
            $respondWith->statusCode(),
        )->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            $respondWith->asArray(),
        ));

        return $response;
    }
}
