<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\GetProjectDetails;

use MissionControlBackend\Projects\Project;
use Psr\Http\Message\ResponseInterface;

use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetProjectDetailsResponderFound implements GetProjectDetailsResponder
{
    public function __construct(
        private Project $project,
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
            $this->project->asArray(),
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
