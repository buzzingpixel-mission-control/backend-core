<?php

declare(strict_types=1);

namespace MissionControlBackend\Dependencies;

use MissionControlBackend\ContainerBindings;
use MissionControlBackend\Mailer\MailerConfig;
use MissionControlBackend\Mailer\MailerConfigFactory;
use MissionControlBackend\Mailer\SystemFromAddress;
use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;

use function assert;
use function implode;

class RegisterBindingsMailer
{
    public static function register(ContainerBindings $containerBindings): void
    {
        $containerBindings->addBinding(
            MailerConfig::class,
            static function (ContainerInterface $container): MailerConfig {
                $factory = $container->get(MailerConfigFactory::class);

                assert($factory instanceof MailerConfigFactory);

                return $factory->create();
            },
        );

        $containerBindings->addBinding(
            MailerInterface::class,
            Mailer::class,
        );

        $containerBindings->addBinding(
            SystemFromAddress::class,
            static function (ContainerInterface $container): SystemFromAddress {
                $mailerConfig = $container->get(MailerConfig::class);

                assert($mailerConfig instanceof MailerConfig);

                return new SystemFromAddress(
                    new Address(
                        $mailerConfig->systemFromAddress,
                        $mailerConfig->systemFromName,
                    ),
                );
            },
        );

        $containerBindings->addBinding(
            TransportInterface::class,
            static function (
                ContainerInterface $container,
            ): TransportInterface {
                $mailerConfig = $container->get(MailerConfig::class);

                assert($mailerConfig instanceof MailerConfig);

                $userPassParts = [
                    $mailerConfig->user,
                    $mailerConfig->password,
                ];

                $dsnParts = [
                    $mailerConfig->protocol,
                    '://',
                    implode(':', $userPassParts),
                    '@',
                    $mailerConfig->host,
                    ':',
                    $mailerConfig->port,
                ];

                $dsn = implode('', $dsnParts);

                return Transport::fromDsn($dsn);
            },
        );
    }
}
