<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use BuzzingPixel\Container\ConstructorParamConfig;
use MissionControlBackend\ContainerBindings;
use Symfony\Component\Console\Input\ArgvInput;

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
    }
}
