<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\GetProjectDetails;

use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlBackend\Projects\Persistence\FindProjectParameters;
use MissionControlBackend\Projects\ProjectRepository;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_string;

readonly class GetProjectDetailsBySlugAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->any('/projects/{slug}', self::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(
        private ProjectRepository $repository,
        private GetProjectDetailsResponderFactory $responderFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $slug = $request->getAttribute('slug');

        assert(is_string($slug));

        $project = $this->repository->findOneOrNull(
            FindProjectParameters::create()->withSlug($slug),
        );

        return $this->responderFactory->createResponder(
            $request,
            $response,
            $project,
        )->respond();
    }
}
