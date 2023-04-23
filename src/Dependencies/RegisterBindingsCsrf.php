<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Csrf\Guard as Csrf;

use function assert;
use function session_start;
use function session_status;

use const PHP_SESSION_ACTIVE;

class RegisterBindingsCsrf
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            key: Csrf::class,
            value: static function (ContainerInterface $container): Csrf {
                // Slim's CSRF requires an active session
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }

                $responseFactory = $container->get(
                    ResponseFactoryInterface::class,
                );

                assert(
                    $responseFactory instanceof ResponseFactoryInterface,
                );

                return new Csrf(
                    responseFactory: $responseFactory,
                    persistentTokenMode: true,
                );
            },
        );
    }
}
