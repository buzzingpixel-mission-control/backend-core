<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

readonly class AddMigrationPathsEvent
{
    public function __construct(
        public MigrationPathCollection $paths,
    ) {
    }
}
