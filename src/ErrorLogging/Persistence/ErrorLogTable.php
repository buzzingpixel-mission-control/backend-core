<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use Phinx\Db\Adapter\PostgresAdapter;
use Phinx\Db\Table;
use Phinx\Migration\MigrationInterface;

class ErrorLogTable
{
    public const TABLE_NAME = 'error_log';

    public static function createSchema(MigrationInterface $migration): Table
    {
        return $migration->table(
            self::TABLE_NAME,
            [
                'id' => false,
                'primary_key' => ['id'],
            ],
        )
            ->addColumn(
                'id',
                PostgresAdapter::PHINX_TYPE_UUID,
            )
            ->addColumn(
                'hash',
                PostgresAdapter::PHINX_TYPE_STRING,
            )
            ->addColumn(
                'message',
                PostgresAdapter::PHINX_TYPE_TEXT,
            )
            ->addColumn(
                'file',
                PostgresAdapter::PHINX_TYPE_TEXT,
            )
            ->addColumn(
                'line',
                PostgresAdapter::PHINX_TYPE_SMALL_INTEGER,
            )
            ->addColumn(
                'trace',
                PostgresAdapter::PHINX_TYPE_TEXT,
            )
            ->addColumn(
                'last_error_at',
                PostgresAdapter::PHINX_TYPE_DATETIME,
            )
            ->addIndex(['hash']);
    }
}
