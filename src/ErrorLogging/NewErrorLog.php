<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use MissionControlBackend\ErrorLogging\ValueObjects\File;
use MissionControlBackend\ErrorLogging\ValueObjects\Line;
use MissionControlBackend\ErrorLogging\ValueObjects\Message;
use MissionControlBackend\ErrorLogging\ValueObjects\Trace;
use Spatie\Cloneable\Cloneable;

readonly class NewErrorLog
{
    use Cloneable;

    public function __construct(
        public Message $message,
        public File $file,
        public Line $line,
        public Trace $trace,
    ) {
    }
}
