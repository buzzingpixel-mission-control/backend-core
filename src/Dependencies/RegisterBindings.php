<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;

class RegisterBindings
{
    public static function register(ContainerBindings $containerBindings): void
    {
        RegisterBindingsCli::register($containerBindings);
        RegisterBindingsCookies::register($containerBindings);
        RegisterBindingsCsrf::register($containerBindings);
        RegisterBindingsDatabase::register($containerBindings);
        RegisterBindingsEvents::register($containerBindings);
        RegisterBindingsLogging::register($containerBindings);
        RegisterBindingsMailer::register($containerBindings);
        RegisterBindingsPhinx::register($containerBindings);
        RegisterBindingsResponse::register($containerBindings);
        RegisterBindingsScheduler::register($containerBindings);
        RegisterBindingsSlim::register($containerBindings);
        RegisterClockBindings::register($containerBindings);
        RegisterBindingsSlack::register($containerBindings);
    }
}
