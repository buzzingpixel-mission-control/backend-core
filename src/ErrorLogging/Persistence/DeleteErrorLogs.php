<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use MissionControlBackend\ActionResult;
use MissionControlBackend\Persistence\MissionControlPdo;

use function array_fill;
use function array_values;
use function count;
use function implode;

class DeleteErrorLogs
{
    public function __construct(private MissionControlPdo $pdo)
    {
    }

    /** @param string[] $ids */
    public function deleteByIds(array $ids): ActionResult
    {
        $ids = array_values($ids);

        $in = implode(
            ',',
            array_fill(
                0,
                count($ids),
                '?',
            ),
        );

        $statement = $this->pdo->prepare(implode(' ', [
            'DELETE FROM',
            ErrorLogRecord::getTableName(),
            'WHERE id IN (' . $in . ')',
        ]));

        if (! $statement->execute($ids)) {
            return new ActionResult(
                false,
                $this->pdo->errorInfo(),
                $this->pdo->errorCode(),
            );
        }

        return new ActionResult();
    }
}
