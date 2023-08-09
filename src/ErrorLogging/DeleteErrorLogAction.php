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

use function assert;
use function is_string;

readonly class DeleteErrorLogAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->delete('/error-logs/{id}', self::class)
            /** @phpstan-ignore-next-line */
            ->add(RequireAdminMiddleware::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(
        private ErrorLogRepository $repository,
        private JsonResponder $jsonResponder,
        private ActionResultResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $id = $request->getAttribute('id');
        assert(is_string($id));

        $item = $this->repository->findOne(
            FindErrorLogParameters::create()
                ->withId($id),
        );

        return $this->jsonResponder->respond(
            $this->responseFactory->createResponse(
                $this->repository->delete($item),
            ),
        );
    }
}
