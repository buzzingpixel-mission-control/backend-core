<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

readonly class MigrationPath
{
    public function __construct(public string $path)
    {
    }
}
