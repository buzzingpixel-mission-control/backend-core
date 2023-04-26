<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\AddEditProject;

use MissionControlBackend\ActionResultResponseFactory;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlBackend\Http\JsonResponse\JsonResponder;
use MissionControlBackend\Projects\NewProject;
use MissionControlBackend\Projects\ProjectRepository;
use MissionControlBackend\Projects\ValueObjects\Description;
use MissionControlBackend\Projects\ValueObjects\Slug;
use MissionControlBackend\Projects\ValueObjects\Title;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function is_array;

readonly class PostAddProjectAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->any('/projects/add', self::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(
        private JsonResponder $jsonResponder,
        private ProjectRepository $projectRepository,
        private ActionResultResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $rawPostData = $request->getParsedBody();

        $postData = PostDataAddProject::fromRawPostData(
            is_array($rawPostData) ? $rawPostData : [],
        );

        return $this->jsonResponder->respond(
            $this->responseFactory->createResponse(
                $this->projectRepository->createProject(
                    new NewProject(
                        Title::fromNative(
                            $postData->title->toNative(),
                        ),
                        Slug::fromNative(
                            $postData->slug->toNative(),
                        ),
                        description: Description::fromNative(
                            $postData->description->toNative(),
                        ),
                    ),
                ),
            ),
        );
    }
}
