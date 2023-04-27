<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\GetProjectDetails;

use Psr\Http\Message\ResponseInterface;

interface GetProjectDetailsResponder
{
    public function respond(): ResponseInterface;
}
