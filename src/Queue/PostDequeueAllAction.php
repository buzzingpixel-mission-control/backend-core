<?php

declare(strict_types=1);

namespace MissionControlBackend\Queue;

use BuzzingPixel\Queue\QueueHandler;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_string;
use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class PostDequeueAllAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->delete('/queue/dequeue/all/{queueName}', self::class)
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
        $queueName = $request->getAttribute('queueName');

        assert(is_string($queueName));

        $this->queueHandler->deQueueAllItems($queueName);

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
