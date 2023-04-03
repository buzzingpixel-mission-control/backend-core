<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

use RuntimeException;

enum DbAdapter
{
    case MYSQL;
    case PGSQL;
    case SQLITE;
    case SQLSRV;

    public function toString(): string
    {
        return match ($this) {
            self::MYSQL => 'mysql',
            self::PGSQL => 'pgsql',
            self::SQLITE => 'sqlite',
            self::SQLSRV => 'sqlsrv',
        };
    }

    public static function fromString(string $adapter): self
    {
        return match ($adapter) {
            'mysql' => self::MYSQL,
            'pgsql' => self::PGSQL,
            'sqlite' => self::SQLITE,
            'sqlsrv' => self::SQLSRV,
            default => throw new RuntimeException(
                $adapter . ' is not supported',
            ),
        };
    }
}
