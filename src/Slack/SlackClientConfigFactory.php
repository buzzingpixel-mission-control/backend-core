<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack;

use Psr\EventDispatcher\EventDispatcherInterface;
use RuntimeException;

use function implode;

readonly class SlackClientConfigFactory
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function create(): SlackClientConfig
    {
        $event = new ApplySlackClientConfigEvent();

        $this->eventDispatcher->dispatch($event);

        if ($event->config === null) {
            throw new RuntimeException(
                implode(' ', [
                    'You must listen for the event',
                    ApplySlackClientConfigEvent::class,
                    'and set up a SlackClientConfig',
                ]),
            );
        }

        return $event->config;
    }
}
