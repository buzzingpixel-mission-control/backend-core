<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use RuntimeException;

use function implode;

readonly class PhinxConfigFactory
{
    public function __construct(
        private ContainerInterface $container,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function create(): PhinxConfig
    {
        $paths = new MigrationPathCollection();

        $this->eventDispatcher->dispatch(
            new AddMigrationPathsEvent($paths),
        );

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

        return new PhinxConfig(
            container: $this->container,
            paths: $paths,
            dbConfig: $dbConfigEvent->config,
        );
    }
}
