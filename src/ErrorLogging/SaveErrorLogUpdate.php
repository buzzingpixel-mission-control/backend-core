<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use function assert;

readonly class SaveErrorLogUpdate implements SaveErrorLog
{
    public function __construct(private ErrorLogRepository $repository)
    {
    }

    public function save(ErrorLog|NewErrorLog $errorLog): void
    {
        assert($errorLog instanceof ErrorLog);

        $this->repository->save($errorLog);
    }
}
