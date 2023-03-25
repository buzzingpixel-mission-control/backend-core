<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use MissionControlBackend\Events\StoppableEvent;

class AddMigrationPathsEvent extends StoppableEvent
{
    public function __construct(
        public readonly MigrationPathCollection $paths,
    ) {
    }
}
