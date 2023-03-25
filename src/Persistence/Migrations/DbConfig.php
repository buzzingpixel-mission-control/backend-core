<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

readonly class DbConfig
{
    public function __construct(
        public DbAdapter $adapter,
        public string $host,
        public string $name,
        public string $user,
        public string $pass,
        public int $port,
        public string $charset = 'utf8mb4',
        public string $collation = 'utf8mb4_unicode_ci',
    ) {
    }
}
