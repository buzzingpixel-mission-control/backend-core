<?php

declare(strict_types=1);

namespace MissionControlBackend\Scheduler;

use BuzzingPixel\Scheduler\ScheduleItem;

class ApplyScheduleEvent
{
    /** @var ScheduleItem[] */
    private array $scheduleItems = [];

    public function __construct()
    {
    }

    /** @return ScheduleItem[] */
    public function scheduleItems(): array
    {
        return $this->scheduleItems;
    }

    public function addScheduleItem(ScheduleItem $scheduleItem): self
    {
        $this->scheduleItems[] = $scheduleItem;

        return $this;
    }
}
