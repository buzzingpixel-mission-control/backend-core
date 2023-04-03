<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Persistence\DbConfig;
use MissionControlBackend\Persistence\DbConfigFactory;
use MissionControlBackend\Persistence\MissionControlPdo;
use MissionControlBackend\Persistence\MissionControlPdoFactory;
use Psr\Container\ContainerInterface;

use function assert;

class RegisterBindingsDatabase
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            DbConfig::class,
            static function (ContainerInterface $container): DbConfig {
                $factory = $container->get(DbConfigFactory::class);

                assert($factory instanceof DbConfigFactory);

                return $factory->create();
            },
        );

        $containerBindings->addBinding(
            MissionControlPdo::class,
            static function (ContainerInterface $container): MissionControlPdo {
                $factory = $container->get(MissionControlPdoFactory::class);

                assert($factory instanceof MissionControlPdoFactory);

                return $factory->create();
            },
        );
    }
}
