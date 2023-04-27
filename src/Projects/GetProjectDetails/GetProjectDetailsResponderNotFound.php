<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\GetProjectDetails;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

readonly class GetProjectDetailsResponderNotFound implements GetProjectDetailsResponder
{
    public function __construct(private ServerRequestInterface $request)
    {
    }

    public function respond(): ResponseInterface
    {
        throw new HttpNotFoundException($this->request);
    }
}
