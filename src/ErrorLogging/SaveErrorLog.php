<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

interface SaveErrorLog
{
    public function save(ErrorLog|NewErrorLog $errorLog): void;
}
