<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use Crell\Tukio\OrderedProviderInterface;

class RegisterEvents
{
    public static function register(OrderedProviderInterface $provider): void
    {
        $provider->addSubscriber(
            RegisterCliCommands::class,
            RegisterCliCommands::class,
        );

        $provider->addSubscriber(
            RegisterHttpMiddleware::class,
            RegisterHttpMiddleware::class,
        );

        $provider->addSubscriber(
            RegisterRoutes::class,
            RegisterRoutes::class,
        );
    }
}
