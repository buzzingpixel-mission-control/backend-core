<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\ErrorHandling;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Throwable;

use function json_encode;

readonly class JsonResponder implements Responder
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function respond(Throwable $exception): ResponseInterface
    {
        $json = [
            'type' => 'error',
            'code' => 500,
            'message' => 'Server error.',
        ];

        $response = $this->responseFactory->createResponse(500)
            ->withHeader('Content-Type', 'application/json');

        // 404 instead of 500
        if ($exception instanceof HttpNotFoundException) {
            $response = $response->withStatus(404);

            $json['code'] = 404;

            $json['message'] = 'Not found.';
        }

        $response->getBody()->write((string) json_encode($json));

        return $response;
    }
}
