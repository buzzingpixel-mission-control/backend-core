<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use MissionControlBackend\Persistence\DbConfig;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

readonly class PhinxConfigFactory
{
    public function __construct(
        private DbConfig $dbConfig,
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

        return new PhinxConfig(
            container: $this->container,
            paths: $paths,
            dbConfig: $this->dbConfig,
        );
    }
}
