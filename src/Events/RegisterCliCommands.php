<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use MissionControlBackend\Cli\ApplyCliCommandsEvent;
use MissionControlBackend\Persistence\Migrations\MigrateCreateCommand;
use MissionControlBackend\Persistence\Migrations\MigrateRollbackCommand;
use MissionControlBackend\Persistence\Migrations\MigrateStatusCommand;
use MissionControlBackend\Persistence\Migrations\MigrateUpCommand;

class RegisterCliCommands
{
    public function onApplyCommands(ApplyCliCommandsEvent $event): void
    {
        MigrateCreateCommand::register($event->app);
        MigrateRollbackCommand::register($event->app);
        MigrateStatusCommand::register($event->app);
        MigrateUpCommand::register($event->app);
    }
}
