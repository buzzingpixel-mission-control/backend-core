<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use BuzzingPixel\Scheduler\RedisDriver\RedisScheduleHandler;
use BuzzingPixel\Scheduler\ScheduleHandler;
use BuzzingPixel\Scheduler\SchedulerTimeZone;
use DateTimeZone;
use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Scheduler\ScheduleFactory;

class RegisterBindingsScheduler
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            ScheduleHandler::class,
            RedisScheduleHandler::class,
        );

        $containerBindings->addBinding(
            \BuzzingPixel\Scheduler\ScheduleFactory::class,
            ScheduleFactory::class,
        );

        $containerBindings->addBinding(
            SchedulerTimeZone::class,
            static fn () => new SchedulerTimeZone(
                new DateTimeZone('US/Central'),
            ),
        );
    }
}
