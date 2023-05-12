<?php

declare(strict_types=1);

namespace MissionControlBackend\Scheduler;

use BuzzingPixel\Scheduler\PersistentScheduleItem;
use BuzzingPixel\Scheduler\ScheduleHandler;
use DateTimeInterface;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlIdp\Authorize\RequireAdminMiddleware;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetScheduleList
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->get('/schedule', self::class)
            /** @phpstan-ignore-next-line */
            ->add(RequireAdminMiddleware::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(private ScheduleHandler $scheduleHandler)
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $response = $response->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            $this->scheduleHandler->fetchSchedule()->map(
                static function (PersistentScheduleItem $item): array {
                    return [
                        'key' => $item->key(),
                        'runEvery' => $item->runEvery->name,
                        'class' => $item->class,
                        'method' => $item->method,
                        'lastRunStartAt' => $item->lastRunStartAt?->format(
                            DateTimeInterface::ATOM,
                        ),
                        'lastRunEndAt' => $item->lastRunEndAt?->format(
                            DateTimeInterface::ATOM,
                        ),
                    ];
                },
            ),
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
