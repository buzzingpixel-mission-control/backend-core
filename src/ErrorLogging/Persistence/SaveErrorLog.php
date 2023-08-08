<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use MissionControlBackend\ActionResult;
use MissionControlBackend\Persistence\MissionControlPdo;

use function implode;

readonly class SaveErrorLog
{
    public function __construct(private MissionControlPdo $pdo)
    {
    }

    public function save(ErrorLogRecord $record): ActionResult
    {
        $statement = $this->pdo->prepare(implode(' ', [
            'UPDATE',
            $record->tableName(),
            'SET',
            $record->columnsAsUpdateSetPlaceholders(),
            'WHERE id = :id',
        ]));

        if (! $statement->execute($record->asParametersArray())) {
            return new ActionResult(
                false,
                $this->pdo->errorInfo(),
                $this->pdo->errorCode(),
            );
        }

        return new ActionResult();
    }
}
