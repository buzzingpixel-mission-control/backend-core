<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\ErrorHandling;

use Psr\Http\Message\ResponseInterface;
use Throwable;

interface Responder
{
    public function respond(Throwable $exception): ResponseInterface;
}
