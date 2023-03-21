<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;

class RegisterBindings
{
    public static function register(ContainerBindings $containerBindings): void
    {
        RegisterBindingsCsrf::register(containerBindings: $containerBindings);
        RegisterBindingsEvents::register(containerBindings: $containerBindings);
        RegisterBindingsLogging::register(containerBindings: $containerBindings);
        RegisterBindingsResponse::register(containerBindings: $containerBindings);
    }
}
