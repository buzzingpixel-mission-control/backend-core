<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

readonly class SaveErrorLogFactory
{
    public function __construct(
        private SaveErrorLogUpdate $update,
        private SaveErrorLogInsertNew $insertNew,
    ) {
    }

    public function create(ErrorLog|NewErrorLog $errorLog): SaveErrorLog
    {
        if ($errorLog instanceof ErrorLog) {
            return $this->update;
        }

        return $this->insertNew;
    }
}
