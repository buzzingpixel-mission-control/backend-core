<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use BuzzingPixel\Container\ConstructorParamConfig;
use MissionControlBackend\ContainerBindings;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterBindingsCli
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addConstructorParamConfig(
            new ConstructorParamConfig(
                id: ArgvInput::class,
                param: 'argv',
                give: null,
            ),
        );

        $containerBindings->addConstructorParamConfig(
            new ConstructorParamConfig(
                id: ArgvInput::class,
                param: 'definition',
                give: null,
            ),
        );

        $containerBindings->addBinding(
            OutputInterface::class,
            ConsoleOutput::class,
        );
    }
}
