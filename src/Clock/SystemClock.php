<?php

declare(strict_types=1);

namespace MissionControlBackend\Clock;

use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;

class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return new DateTimeImmutable(
            'now',
            new DateTimeZone('UTC'),
        );
    }
}
