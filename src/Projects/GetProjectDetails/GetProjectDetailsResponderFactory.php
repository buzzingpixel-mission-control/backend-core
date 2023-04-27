<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\GetProjectDetails;

use MissionControlBackend\Projects\Project;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetProjectDetailsResponderFactory
{
    public function createResponder(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Project|null $project,
    ): GetProjectDetailsResponder {
        if ($project === null) {
            return new GetProjectDetailsResponderNotFound(
                $request,
            );
        }

        return new GetProjectDetailsResponderFound(
            $project,
            $response,
        );
    }
}
