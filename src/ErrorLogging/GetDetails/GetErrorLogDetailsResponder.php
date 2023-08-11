<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\GetDetails;

use Psr\Http\Message\ResponseInterface;

interface GetErrorLogDetailsResponder
{
    public function respond(): ResponseInterface;
}
