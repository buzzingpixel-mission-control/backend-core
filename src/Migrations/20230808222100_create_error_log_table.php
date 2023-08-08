<?php

declare(strict_types=1);

use MissionControlBackend\ErrorLogging\Persistence\ErrorLogTable;
use MissionControlBackend\Persistence\Migrations\ChangeMigration;

/** @noinspection PhpUnused */
/** @noinspection PhpIllegalPsrClassPathInspection */
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace, Squiz.Classes.ClassFileName.NoMatch

class CreateErrorLogTable extends ChangeMigration
{
    public function change(): void
    {
        ErrorLogTable::createSchema($this)->create();
    }
}
