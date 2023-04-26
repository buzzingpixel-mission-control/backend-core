<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\Persistence;

use MissionControlBackend\Persistence\Record;
use MissionControlBackend\Projects\NewProject;
use MissionControlBackend\Projects\Project;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

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

    public static function fromNewEntity(NewProject $entity): self
    {
        $record = new self();

        $record->is_active = $entity->isActive->toNative();

        $record->title = $entity->title->toNative();

        $record->slug = $entity->slug->toNative();

        $record->description = $entity->description->toNative();

        return $record;
    }

    public static function fromEntity(Project $entity): self
    {
        $record = new self();

        $record->id = $entity->id->toNative();

        $record->is_active = $entity->isActive->toNative();

        $record->title = $entity->title->toNative();

        $record->slug = $entity->slug->toNative();

        $record->description = $entity->description->toNative();

        $record->created_at = $entity->createdAt->toNative();

        return $record;
    }

    /** Primary key */
    public string $id = '';

    public bool $is_active = true;

    public string $title = '';

    public string $slug = '';

    public string $description = '';

    public string $created_at = '';
}
