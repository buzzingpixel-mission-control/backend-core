<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use Phinx\Migration\AbstractMigration;

abstract class ChangeMigration extends AbstractMigration
{
    abstract public function change(): void;
}
