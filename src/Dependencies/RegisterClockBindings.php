<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use Lcobucci\Clock\SystemClock;
use MissionControlBackend\ContainerBindings;
use Psr\Clock\ClockInterface;

class RegisterClockBindings
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            ClockInterface::class,
            SystemClock::fromUTC(),
        );
    }
}
