<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\Persistence;

use MissionControlBackend\Persistence\MissionControlPdo;
use PDO;
use Throwable;

readonly class FindProjects
{
    public function __construct(private MissionControlPdo $pdo)
    {
    }

    public function findOne(
        FindProjectParameters|null $parameters = null,
    ): ProjectRecord {
        $parameters ??= new FindProjectParameters();

        $parameters = $parameters->with(limit: 1);

        return $this->findAll($parameters)->first();
    }

    public function findOneOrNull(
        FindProjectParameters|null $parameters = null,
    ): ProjectRecord|null {
        $parameters ??= new FindProjectParameters();

        $parameters = $parameters->with(limit: 1);

        return $this->findAll($parameters)->firstOrNull();
    }

    public function findAll(
        FindProjectParameters|null $parameters = null,
    ): ProjectRecordCollection {
        try {
            $parameters ??= new FindProjectParameters();

            $customQuery = $parameters->buildQuery();

            $statement = $this->pdo->prepare($customQuery->query);

            $statement->execute($customQuery->params);

            $results = $statement->fetchAll(
                PDO::FETCH_CLASS,
                ProjectRecord::class,
            );

            return new ProjectRecordCollection(
                $results !== false ? $results : [],
            );
        } catch (Throwable) {
            return new ProjectRecordCollection();
        }
    }
}
