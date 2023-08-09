<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use MissionControlBackend\ErrorLogging\Persistence\FindErrorLogParameters;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlBackend\Persistence\Sort;
use MissionControlIdp\Authorize\RequireAdminMiddleware;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetErrorLogsListAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->get('/error-logs/list', self::class)
            /** @phpstan-ignore-next-line */
            ->add(RequireAdminMiddleware::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(private ErrorLogRepository $repository)
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $items = $this->repository->findAll(
            FindErrorLogParameters::create()
                ->withOrderBy('last_error_at')
                ->withSort(Sort::ASC),
        );

        $response = $response->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            $items->asArray(),
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
