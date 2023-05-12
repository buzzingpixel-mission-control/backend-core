<?php

declare(strict_types=1);

namespace MissionControlBackend\Queue\QueueDetails;

use BuzzingPixel\Queue\QueueHandler;
use MissionControlBackend\Http\ApplyRoutesEvent;
use MissionControlIdp\Authorize\RequireAdminMiddleware;
use MissionControlIdp\Authorize\ResourceServerMiddlewareWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

use function array_filter;
use function array_values;
use function assert;
use function is_string;
use function json_encode;

use const JSON_PRETTY_PRINT;

readonly class GetQueueDetailsByQueueNameAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->get('/queue/{queueName}', self::class)
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
        $queueName = $request->getAttribute('queueName');

        assert(is_string($queueName));

        $queue = array_values(array_filter(
            $this->queueHandler->getAvailableQueuesWithTotals(),
            static fn (array $item) => $item['queue'] === $queueName,
        ))[0] ?? null;

        if ($queue === null) {
            throw new HttpNotFoundException($request);
        }

        $totalItemsInQueue = $queue['totalItemsInQueue'];

        $response = $response->withHeader(
            'Content-type',
            'application/json',
        );

        $response->getBody()->write((string) json_encode(
            [
                'queue' => $queueName,
                'totalItemsInQueue' => $totalItemsInQueue,
                'items' => $this->queueHandler->getEnqueuedItems(
                    $queueName,
                )->asArray(),
            ],
            JSON_PRETTY_PRINT,
        ));

        return $response;
    }
}
