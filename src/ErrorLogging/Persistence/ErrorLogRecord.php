<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use MissionControlBackend\ErrorLogging\ErrorLog;
use MissionControlBackend\ErrorLogging\NewErrorLog;
use MissionControlBackend\Persistence\Record;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

class ErrorLogRecord extends Record
{
    public static function getTableName(): string
    {
        return ErrorLogTable::TABLE_NAME;
    }

    public function tableName(): string
    {
        return ErrorLogTable::TABLE_NAME;
    }

    public static function fromNewEntity(NewErrorLog $entity): self
    {
        $record = new self();

        $record->message = $entity->message->toNative();

        $record->file = $entity->file->toNative();

        $record->line = $entity->line->toNative();

        $record->trace = $entity->trace->toNative();

        return $record;
    }

    public static function fromEntity(ErrorLog $entity): self
    {
        $record = new self();

        $record->id = $entity->id->toNative();

        $record->hash = $entity->hash->toNative();

        $record->message = $entity->message->toNative();

        $record->file = $entity->file->toNative();

        $record->line = $entity->line->toNative();

        $record->trace = $entity->trace->toNative();

        $record->last_error_at = $entity->lastErrorAt->toNative();

        return $record;
    }

    /** Primary key */
    public string $id = '';

    public string $hash = '';

    public string $message = '';

    public string $file = '';

    public int $line = 0;

    public string $trace = '';

    public string $last_error_at = '';
}
