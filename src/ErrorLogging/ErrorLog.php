<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use DateTimeImmutable;
use MissionControlBackend\ErrorLogging\Persistence\ErrorLogRecord;
use MissionControlBackend\ErrorLogging\ValueObjects\File;
use MissionControlBackend\ErrorLogging\ValueObjects\Hash;
use MissionControlBackend\ErrorLogging\ValueObjects\Id;
use MissionControlBackend\ErrorLogging\ValueObjects\LastErrorAt;
use MissionControlBackend\ErrorLogging\ValueObjects\Line;
use MissionControlBackend\ErrorLogging\ValueObjects\Message;
use MissionControlBackend\ErrorLogging\ValueObjects\Trace;
use Spatie\Cloneable\Cloneable;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class ErrorLog
{
    use Cloneable;

    public static function fromRecord(ErrorLogRecord $record): self
    {
        return new self(
            Id::fromNative($record->id),
            Hash::fromNative($record->hash),
            Message::fromNative($record->message),
            File::fromNative($record->file),
            Line::fromNative($record->line),
            Trace::fromNative($record->trace),
            LastErrorAt::fromNative($record->last_error_at),
        );
    }

    public function __construct(
        public Id $id,
        public Hash $hash,
        public Message $message,
        public File $file,
        public Line $line,
        public Trace $trace,
        public LastErrorAt $lastErrorAt,
    ) {
    }

    /** @return array<string, scalar|null> */
    public function asArray(): array
    {
        return [
            'id' => $this->id->toNative(),
            'hash' => $this->hash->toNative(),
            'message' => $this->message->toNative(),
            'file' => $this->file->toNative(),
            'line' => $this->line->toNative(),
            'trace' => $this->trace->toNative(),
            'lastErrorAt' => $this->lastErrorAt->toNative(),
        ];
    }

    public function withLastErrorAt(DateTimeImmutable $date): self
    {
        return $this->with(lastErrorAt: new LastErrorAt($date));
    }
}
