<?php

declare(strict_types=1);

namespace MissionControlBackend\Queue;

use BuzzingPixel\Queue\QueueHandler;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlIdp\Authorize\RequireAdminMiddleware;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_string;
use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class PostDequeueItemAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->delete('/queue/dequeue/{key}', self::class)
            /** @phpstan-ignore-next-line */
            ->add(RequireAdminMiddleware::class)
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
        $key = $request->getAttribute('key');

        assert(is_string($key));

        $this->queueHandler->deQueue($key);

        $response = $response->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            [],
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
