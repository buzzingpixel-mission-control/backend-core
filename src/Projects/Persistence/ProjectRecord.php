<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\Persistence;

use MissionControlBackend\Persistence\Record;

class ProjectRecord extends Record
{
    public static function getTableName(): string
    {
        return ProjectsTable::TABLE_NAME;
    }

    public function tableName(): string
    {
        return ProjectsTable::TABLE_NAME;
    }
}
