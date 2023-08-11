<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\GetDetails;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

readonly class GetErrorLogDetailsResponderNotFound implements GetErrorLogDetailsResponder
{
    public function __construct(private ServerRequestInterface $request)
    {
    }

    public function respond(): ResponseInterface
    {
        throw new HttpNotFoundException($this->request);
    }
}
