<?php

declare(strict_types=1);

namespace MissionControlBackend\Queue;

use BuzzingPixel\Queue\QueueHandler;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetQueueListAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->any('/queue/list', self::class)
            /** @phpstan-ignore-next-line */
            ->add(ResourceServerMiddlewareWrapper::class);
    }

    public function __construct(private QueueHandler $queueHandler)
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
            $this->queueHandler->getAvailableQueuesWithTotals(),
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
