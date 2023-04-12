<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use BuzzingPixel\Container\ConstructorParamConfig;
use HttpSoft\Cookie\CookieManager;
use HttpSoft\Cookie\CookieManagerInterface;
use HttpSoft\Cookie\CookieSendMiddleware;
use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Cookies\CookieConfig;
use MissionControlBackend\Cookies\CookieConfigFactory;
use Psr\Container\ContainerInterface;

use function assert;

class RegisterBindingsCookies
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            CookieConfig::class,
            static function (ContainerInterface $container): CookieConfig {
                $factory = $container->get(CookieConfigFactory::class);

                assert($factory instanceof CookieConfigFactory);

                return $factory->create();
            },
        );

        $containerBindings->addBinding(
            CookieManagerInterface::class,
            CookieManager::class,
        );

        $containerBindings->addConstructorParamConfig(
            new ConstructorParamConfig(
                CookieSendMiddleware::class,
                'removeResponseCookies',
                false,
            ),
        );
    }
}
