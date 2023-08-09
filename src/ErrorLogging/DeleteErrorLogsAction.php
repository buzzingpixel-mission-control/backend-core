<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use MissionControlBackend\ActionResultResponseFactory;
use MissionControlBackend\ErrorLogging\Persistence\FindErrorLogParameters;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlBackend\Http\JsonResponse\JsonResponder;
use MissionControlIdp\Authorize\RequireAdminMiddleware;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;

readonly class DeleteErrorLogsAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->delete('/error-logs', self::class)
            /** @phpstan-ignore-next-line */
            ->add(RequireAdminMiddleware::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(
        private JsonResponder $jsonResponder,
        private ErrorLogRepository $repository,
        private ActionResultResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        /**
         * @var string[] $errorLogIds
         * @phpstan-ignore-next-line
         */
        $errorLogIds = json_decode(
            (string) $request->getBody(),
            true,
        )['errorLogIds'] ?? [];

        /**
         * Placeholder to prevent empty array from acting on every single item
         * If an empty array is provided to find all, all items will be found
         */
        $errorLogIds[] = '8a417645-72dd-45e3-9e7e-5dde5cf8f18c';

        return $this->jsonResponder->respond(
            $this->responseFactory->createResponse(
                $this->repository->deleteCollection(
                    $this->repository->findAll(
                        FindErrorLogParameters::create()
                            ->withIds($errorLogIds),
                    ),
                ),
            ),
        );
    }
}
