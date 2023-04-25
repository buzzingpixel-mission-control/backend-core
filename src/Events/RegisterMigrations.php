<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use MissionControlBackend\BackendCoreSrc;
use MissionControlBackend\Persistence\Migrations\AddMigrationPathsEvent;

class RegisterMigrations
{
    public function onAddMigrationPaths(AddMigrationPathsEvent $event): void
    {
        $event->paths->addPathFromString(
            BackendCoreSrc::path() . '/Migrations',
        );
    }
}
