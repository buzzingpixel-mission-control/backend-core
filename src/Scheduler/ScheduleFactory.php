<?php

declare(strict_types=1);

namespace MissionControlBackend\Scheduler;

use BuzzingPixel\Scheduler\ScheduleItemCollection;
use Psr\EventDispatcher\EventDispatcherInterface;

readonly class ScheduleFactory implements \BuzzingPixel\Scheduler\ScheduleFactory
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function createSchedule(): ScheduleItemCollection
    {
        $event = new ApplyScheduleEvent();

        $this->eventDispatcher->dispatch($event);

        return new ScheduleItemCollection(
            $event->scheduleItems(),
        );
    }
}
