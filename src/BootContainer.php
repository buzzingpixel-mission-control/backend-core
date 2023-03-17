<?php

declare(strict_types=1);

namespace MissionControlBackend;

use BuzzingPixel\Container\Container;
use MissionControlBackend\Dependencies\RegisterBindings;

use function assert;

readonly class BootContainer
{
    public function __construct(private CoreConfig $config)
    {
    }

    public function buildContainer(
        callable|null $register = null,
    ): BootEventRegistration {
        $containerBindings = new ContainerBindings();

        $containerBindings->addBinding(
            key: CoreConfig::class,
            value: $this->config,
        );

        RegisterBindings::register(containerBindings: $containerBindings);

        if ($register !== null) {
            $register($containerBindings);
        }

        $constructorConfigs = $containerBindings->constructorParamConfigs();

        $container = new Container(
            bindings: $containerBindings->bindings(),
            constructorParamConfigs: $constructorConfigs,
        );

        $bootEventRegistration = $container->get(BootEventRegistration::class);

        assert(
            $bootEventRegistration instanceof BootEventRegistration,
        );

        return $bootEventRegistration;
    }
}
