<?php

declare(strict_types=1);

namespace MissionControlBackend\Api\Timezone;

use MissionControlBackend\Http\ApplyRoutesEvent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

use function json_encode;

readonly class GetTimezoneListAction
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->get('/utility/timezone-list', self::class);
    }

    public function __construct(private TimezoneList $timezoneList)
    {
    }

    /** @throws Throwable */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $options = $this->timezoneList->getTimezoneListAsOptionsArray();

        $response->getBody()->write(
            (string) json_encode($options),
        );

        return $response;
    }
}
