<?php

declare(strict_types=1);

namespace MissionControlBackend;

use BuzzingPixel\Container\Container;
use MissionControlBackend\Dependencies\RegisterBindings;

use function assert;

readonly class BootContainer
{
    public function buildContainer(
        callable|null $register = null,
    ): BootEvents {
        $containerBindings = new ContainerBindings();

        RegisterBindings::register($containerBindings);

        if ($register !== null) {
            $register($containerBindings);
        }

        $constructorConfigs = $containerBindings->constructorParamConfigs();

        $container = new Container(
            bindings: $containerBindings->bindings(),
            constructorParamConfigs: $constructorConfigs,
        );

        $bootEventRegistration = $container->get(BootEvents::class);

        assert(
            $bootEventRegistration instanceof BootEvents,
        );

        return $bootEventRegistration;
    }
}
