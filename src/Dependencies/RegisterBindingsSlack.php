<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Slack\SlackClientConfig;
use MissionControlBackend\Slack\SlackClientConfigFactory;
use Psr\Container\ContainerInterface;

use function assert;

class RegisterBindingsSlack
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            SlackClientConfig::class,
            static function (ContainerInterface $di): SlackClientConfig {
                $factory = $di->get(SlackClientConfigFactory::class);

                assert($factory instanceof SlackClientConfigFactory);

                return $factory->create();
            },
        );
    }
}
