<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\Persistence;

use Phinx\Db\Table;
use Phinx\Migration\MigrationInterface;

readonly class ProjectsTable
{
    public const TABLE_NAME = 'projects';

    public static function createSchema(MigrationInterface $migration): Table
    {
        return $migration->table(
            self::TABLE_NAME,
            [
                'id' => false,
                'primary_key' => ['id'],
            ],
        )->addColumn(
            'id',
            'uuid',
        )->addColumn(
            'is_active',
            'boolean',
            ['default' => 1],
        )->addColumn(
            'title',
            'string',
        )->addColumn(
            'slug',
            'string',
        )->addColumn(
            'description',
            'text',
        )->addColumn(
            'created_at',
            'datetime',
        )
            ->addIndex(['title'])
            ->addIndex(['slug'])
            ->addIndex(['created_at']);
    }
}
