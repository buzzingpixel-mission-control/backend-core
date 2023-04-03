<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

readonly class DbConfig
{
    public function __construct(
        public DbAdapter $adapter,
        public string $host,
        public string $name,
        public string $user,
        public string $pass,
        public int $port,
    ) {
    }
}
