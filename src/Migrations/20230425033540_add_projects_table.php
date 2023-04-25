<?php

declare(strict_types=1);

use MissionControlBackend\Persistence\Migrations\ChangeMigration;
use MissionControlBackend\Projects\Persistence\ProjectsTable;

/** @noinspection PhpUnused */
/** @noinspection PhpIllegalPsrClassPathInspection */
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace, Squiz.Classes.ClassFileName.NoMatch

class AddProjectsTable extends ChangeMigration
{
    public function change(): void
    {
        ProjectsTable::createSchema($this)->create();
    }
}
