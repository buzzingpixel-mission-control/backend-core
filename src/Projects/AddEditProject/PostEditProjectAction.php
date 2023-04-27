<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\AddEditProject;

use MissionControlBackend\ActionResultResponseFactory;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlBackend\Http\JsonResponse\JsonResponder;
use MissionControlBackend\Projects\ProjectRepository;
use MissionControlBackend\Projects\ValueObjects\Description;
use MissionControlBackend\Projects\ValueObjects\Slug;
use MissionControlBackend\Projects\ValueObjects\Title;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_array;
use function is_string;

class PostEditProjectAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->patch('/projects/edit/{projectId}', self::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(
        private JsonResponder $jsonResponder,
        private ProjectRepository $projectRepository,
        private ActionResultResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $projectId = $request->getAttribute('projectId');

        assert(is_string($projectId));

        $project = $this->projectRepository->findOneById($projectId);

        $rawPostData = $request->getParsedBody();

        $postData = PostDataAddProject::fromRawPostData(
            is_array($rawPostData) ? $rawPostData : [],
        );

        return $this->jsonResponder->respond(
            $this->responseFactory->createResponse(
                $this->projectRepository->saveProject(
                    $project->with(title: Title::fromNative(
                        $postData->title->toNative(),
                    ))->with(slug: Slug::fromNative(
                        $postData->slug->toNative(),
                    ))->with(description: Description::fromNative(
                        $postData->description->toNative(),
                    )),
                ),
            ),
        );
    }
}
