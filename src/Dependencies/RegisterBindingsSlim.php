<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Http\SlimHelpers\MissionControlCallableResolver;
use Slim\Interfaces\AdvancedCallableResolverInterface;
use Slim\Interfaces\CallableResolverInterface;

class RegisterBindingsSlim
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            CallableResolverInterface::class,
            MissionControlCallableResolver::class,
        );

        $containerBindings->addBinding(
            AdvancedCallableResolverInterface::class,
            MissionControlCallableResolver::class,
        );
    }
}
