<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

use Psr\EventDispatcher\EventDispatcherInterface;
use RuntimeException;

use function implode;

readonly class DbConfigFactory
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function create(): DbConfig
    {
        $dbConfigEvent = new ApplyDbConfigEvent();

        $this->eventDispatcher->dispatch($dbConfigEvent);

        if ($dbConfigEvent->config === null) {
            throw new RuntimeException(
                implode(' ', [
                    'You must listen for the event',
                    ApplyDbConfigEvent::class,
                    'and set up a DB Config',
                ]),
            );
        }

        return $dbConfigEvent->config;
    }
}
