<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

use PDO;

use function implode;

readonly class MissionControlPdoFactory
{
    public function __construct(private DbConfig $dbConfig)
    {
    }

    public function create(): MissionControlPdo
    {
        $adapter = $this->dbConfig->adapter->toString();

        return new MissionControlPdo(
            implode(';', [
                $adapter . ':host=' . $this->dbConfig->host,
                'port=' . $this->dbConfig->port,
                'dbname=' . $this->dbConfig->name,
            ]),
            $this->dbConfig->user,
            $this->dbConfig->pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        );
    }
}
