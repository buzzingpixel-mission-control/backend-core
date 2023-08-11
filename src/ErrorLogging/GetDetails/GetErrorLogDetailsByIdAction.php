<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\GetDetails;

use MissionControlBackend\ErrorLogging\ErrorLogRepository;
use MissionControlBackend\ErrorLogging\Persistence\FindErrorLogParameters;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlIdp\Authorize\RequireAdminMiddleware;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_string;

readonly class GetErrorLogDetailsByIdAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->get('/error-logs/{id}', self::class)
            /** @phpstan-ignore-next-line */
            ->add(RequireAdminMiddleware::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(
        private ErrorLogRepository $repository,
        private GetErrorLogDetailsResponderFactory $responderFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $id = $request->getAttribute('id');

        assert(is_string($id));

        return $this->responderFactory->createResponder(
            $request,
            $response,
            $this->repository->findOneOrNull(
                FindErrorLogParameters::create()->withId($id),
            ),
        )->respond();
    }
}
