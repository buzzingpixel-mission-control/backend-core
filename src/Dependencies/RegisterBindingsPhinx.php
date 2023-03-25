<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Persistence\Migrations\PhinxConfig;
use MissionControlBackend\Persistence\Migrations\PhinxConfigFactory;
use Phinx\Config\ConfigInterface;
use Phinx\Console\Command\AbstractCommand;
use Phinx\Console\Command\Create;
use Phinx\Console\Command\Migrate;
use Phinx\Console\Command\Rollback;
use Phinx\Console\Command\Status;
use Phinx\Console\PhinxApplication;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

class RegisterBindingsPhinx
{
    /**
     * @param class-string<C> $commandClass
     *
     * @return C
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @template C of AbstractCommand
     */
    private static function createCommand(
        string $commandClass,
        ContainerInterface $container,
    ) {
        $app = $container->get(PhinxApplication::class);

        assert($app instanceof PhinxApplication);

        $config = $container->get(ConfigInterface::class);

        assert($config instanceof ConfigInterface);

        $command = new $commandClass();

        $command->setConfig($config);

        $command->setApplication($app);

        return $command;
    }

    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            ConfigInterface::class,
            PhinxConfig::class,
        );

        $containerBindings->addBinding(
            PhinxConfig::class,
            static function (ContainerInterface $container): PhinxConfig {
                $factory = $container->get(PhinxConfigFactory::class);

                assert($factory instanceof PhinxConfigFactory);

                return $factory->create();
            },
        );

        $containerBindings->addBinding(
            Create::class,
            static fn (ContainerInterface $container) => self::createCommand(
                Create::class,
                $container,
            ),
        );

        $containerBindings->addBinding(
            Rollback::class,
            static fn (ContainerInterface $container) => self::createCommand(
                Rollback::class,
                $container,
            ),
        );

        $containerBindings->addBinding(
            Status::class,
            static fn (ContainerInterface $container) => self::createCommand(
                Status::class,
                $container,
            ),
        );

        $containerBindings->addBinding(
            Migrate::class,
            static fn (ContainerInterface $container) => self::createCommand(
                Migrate::class,
                $container,
            ),
        );
    }
}
