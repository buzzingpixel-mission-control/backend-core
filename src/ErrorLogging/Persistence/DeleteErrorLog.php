<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use MissionControlBackend\ActionResult;
use MissionControlBackend\Persistence\MissionControlPdo;

use function implode;

readonly class DeleteErrorLog
{
    public function __construct(private MissionControlPdo $pdo)
    {
    }

    public function deleteById(string $id): ActionResult
    {
        $statement = $this->pdo->prepare(implode(' ', [
            'DELETE FROM',
            ErrorLogRecord::getTableName(),
            'WHERE ID=:id',
        ]));

        if (! $statement->execute(['id' => $id])) {
            return new ActionResult(
                false,
                $this->pdo->errorInfo(),
                $this->pdo->errorCode(),
            );
        }

        return new ActionResult();
    }
}
