<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\GetDetails;

use MissionControlBackend\ErrorLogging\ErrorLog;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetErrorLogDetailsResponderFactory
{
    public function createResponder(
        ServerRequestInterface $request,
        ResponseInterface $response,
        ErrorLog|null $errorLog,
    ): GetErrorLogDetailsResponder {
        if ($errorLog === null) {
            return new GetErrorLogDetailsResponderNotFound($request);
        }

        return new GetErrorLogDetailsResponderFound(
            $errorLog,
            $response,
        );
    }
}
