<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

use Psr\EventDispatcher\EventDispatcherInterface;
use RuntimeException;

use function implode;

readonly class MailerConfigFactory
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function create(): MailerConfig
    {
        $mailerConfigEvent = new ApplyMailerConfigEvent();

        $this->eventDispatcher->dispatch($mailerConfigEvent);

        if ($mailerConfigEvent->config === null) {
            throw new RuntimeException(
                implode(' ', [
                    'You must listen for the event',
                    ApplyMailerConfigEvent::class,
                    'and set up a Mailer Config',
                ]),
            );
        }

        return $mailerConfigEvent->config;
    }
}
