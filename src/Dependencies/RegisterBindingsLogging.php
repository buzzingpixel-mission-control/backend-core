<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Logging\HandlerFactories\Cli;
use MissionControlBackend\Logging\HandlerFactories\Stderr;
use MissionControlBackend\Logging\HandlerFactories\Stdout;
use MissionControlBackend\Logging\HandlerFactoryClassReference;
use MissionControlBackend\Logging\LoggerFactory;
use MissionControlBackend\Logging\LoggerFactoryConfig;
use Monolog\Processor\IntrospectionProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function assert;
use function mb_strtolower;

use const PHP_SAPI;

class RegisterBindingsLogging
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            IntrospectionProcessor::class,
            static fn () => new IntrospectionProcessor(),
        );

        // This can be overridden in binding listeners
        $containerBindings->addBinding(
            LoggerFactoryConfig::class,
            static function (): LoggerFactoryConfig {
                $stack = [];

                if (mb_strtolower(PHP_SAPI) === 'cli') {
                    $stack[] = new HandlerFactoryClassReference(
                        Cli::class,
                    );
                } else {
                    $stack[] = new HandlerFactoryClassReference(
                        Stderr::class,
                    );

                    $stack[] = new HandlerFactoryClassReference(
                        Stdout::class,
                    );
                }

                return new LoggerFactoryConfig($stack);
            },
        );

        $containerBindings->addBinding(
            LoggerInterface::class,
            static function (ContainerInterface $container): LoggerInterface {
                $loggerFactory = $container->get(LoggerFactory::class);

                assert($loggerFactory instanceof LoggerFactory);

                return $loggerFactory->make();
            },
        );
    }
}
