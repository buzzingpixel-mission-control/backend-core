<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\GetDetails;

use MissionControlBackend\ErrorLogging\ErrorLog;
use Psr\Http\Message\ResponseInterface;

use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetErrorLogDetailsResponderFound implements GetErrorLogDetailsResponder
{
    public function __construct(
        private ErrorLog $errorLog,
        private ResponseInterface $response,
    ) {
    }

    public function respond(): ResponseInterface
    {
        $response = $this->response->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            $this->errorLog->asArray(),
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
