<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use function assert;

readonly class SaveErrorLogInsertNew implements SaveErrorLog
{
    public function __construct(private ErrorLogRepository $repository)
    {
    }

    public function save(ErrorLog|NewErrorLog $errorLog): void
    {
        assert($errorLog instanceof NewErrorLog);

        $this->repository->create($errorLog);
    }
}
