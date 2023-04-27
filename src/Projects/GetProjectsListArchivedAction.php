<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects;

use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlBackend\Persistence\Sort;
use MissionControlBackend\Projects\Persistence\FindProjectParameters;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetProjectsListArchivedAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->any('/projects/list/archived', self::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(private ProjectRepository $repository)
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $projects = $this->repository->findAll(
            (new FindProjectParameters())
                ->withIsActive(false)
                ->withOrderBy('title')
                ->withSort(Sort::ASC),
        );

        $response = $response->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            $projects->asArray(),
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
