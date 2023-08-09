<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use MissionControlBackend\ActionResult;
use MissionControlBackend\ErrorLogging\Persistence\CreateErrorLog;
use MissionControlBackend\ErrorLogging\Persistence\DeleteErrorLog;
use MissionControlBackend\ErrorLogging\Persistence\ErrorLogRecord;
use MissionControlBackend\ErrorLogging\Persistence\FindErrorLogParameters;
use MissionControlBackend\ErrorLogging\Persistence\FindErrorLogs;
use MissionControlBackend\ErrorLogging\Persistence\SaveErrorLog;

readonly class ErrorLogRepository
{
    public function __construct(
        private SaveErrorLog $save,
        private FindErrorLogs $find,
        private CreateErrorLog $create,
        private DeleteErrorLog $delete,
    ) {
    }

    public function create(NewErrorLog $entity): ActionResult
    {
        return $this->create->create(
            ErrorLogRecord::fromNewEntity($entity),
        );
    }

    public function save(ErrorLog $entity): ActionResult
    {
        return $this->save->save(
            ErrorLogRecord::fromEntity($entity),
        );
    }

    public function findOne(
        FindErrorLogParameters|null $parameters = null,
    ): ErrorLog {
        return ErrorLog::fromRecord(
            $this->find->findOne($parameters),
        );
    }

    public function findOneOrNull(
        FindErrorLogParameters|null $parameters = null,
    ): ErrorLog|null {
        $record = $this->find->findOneOrNull($parameters);

        if ($record === null) {
            return null;
        }

        return ErrorLog::fromRecord($record);
    }

    public function findAll(
        FindErrorLogParameters|null $parameters = null,
    ): ErrorLogCollection {
        $records = $this->find->findAll($parameters);

        /** @phpstan-ignore-next-line */
        return new ErrorLogCollection($records->map(
            static fn (ErrorLogRecord $record) => ErrorLog::fromRecord(
                $record,
            ),
        ));
    }

    public function delete(ErrorLog $errorLog): ActionResult
    {
        return $this->delete->deleteById($errorLog->id->toNative());
    }
}
