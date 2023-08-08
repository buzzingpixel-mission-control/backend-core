<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use DateTimeInterface;
use MissionControlBackend\ActionResult;
use MissionControlBackend\Persistence\MissionControlPdo;
use MissionControlBackend\Persistence\UuidFactoryWithOrderedTimeCodec;
use Psr\Clock\ClockInterface;

use function implode;
use function md5;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class CreateErrorLog
{
    public function __construct(
        private ClockInterface $clock,
        private MissionControlPdo $pdo,
        private UuidFactoryWithOrderedTimeCodec $uuidFactory,
    ) {
    }

    public function create(ErrorLogRecord $record): ActionResult
    {
        $record->id = $this->uuidFactory->uuid4()->toString();

        $record->hash = md5(implode('_', [
            $record->message,
            $record->file,
            (string) $record->line,
            $record->trace,
        ]));

        $record->last_error_at = $this->clock->now()->format(
            DateTimeInterface::ATOM,
        );

        $statement = $this->pdo->prepare(implode(' ', [
            'INSERT INTO',
            $record->tableName(),
            $record->columnsAsInsertIntoString(),
            'VALUES',
            $record->columnsAsValuePlaceholders(),
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
