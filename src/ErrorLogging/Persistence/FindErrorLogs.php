<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use MissionControlBackend\Persistence\MissionControlPdo;
use PDO;
use Throwable;

readonly class FindErrorLogs
{
    public function __construct(private MissionControlPdo $pdo)
    {
    }

    public function findOne(
        FindErrorLogParameters|null $parameters = null,
    ): ErrorLogRecord {
        $parameters ??= new FindErrorLogParameters();

        $parameters = $parameters->with(limit: 1);

        return $this->findAll($parameters)->first();
    }

    public function findOneOrNull(
        FindErrorLogParameters|null $parameters = null,
    ): ErrorLogRecord|null {
        $parameters ??= new FindErrorLogParameters();

        $parameters = $parameters->with(limit: 1);

        return $this->findAll($parameters)->firstOrNull();
    }

    public function findAll(
        FindErrorLogParameters|null $parameters = null,
    ): ErrorLogRecordCollection {
        try {
            $parameters ??= new FindErrorLogParameters();

            $customQuery = $parameters->buildQuery();

            $statement = $this->pdo->prepare($customQuery->query);

            $statement->execute($customQuery->params);

            $results = $statement->fetchAll(
                PDO::FETCH_CLASS,
                ErrorLogRecord::class,
            );

            return new ErrorLogRecordCollection(
                $results !== false ? $results : [],
            );
        } catch (Throwable) {
            return new ErrorLogRecordCollection();
        }
    }
}
