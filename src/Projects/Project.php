<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects;

use MissionControlBackend\Projects\Persistence\ProjectRecord;
use MissionControlBackend\Projects\ValueObjects\CreatedAt;
use MissionControlBackend\Projects\ValueObjects\Description;
use MissionControlBackend\Projects\ValueObjects\Id;
use MissionControlBackend\Projects\ValueObjects\IsActive;
use MissionControlBackend\Projects\ValueObjects\Slug;
use MissionControlBackend\Projects\ValueObjects\Title;
use Spatie\Cloneable\Cloneable;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class Project
{
    use Cloneable;

    public static function fromRecord(ProjectRecord $record): self
    {
        return new self(
            Id::fromNative($record->id),
            IsActive::fromNative($record->is_active),
            Title::fromNative($record->title),
            Slug::fromNative($record->slug),
            CreatedAt::fromNative($record->created_at),
            Description::fromNative($record->description),
        );
    }

    public function __construct(
        public Id $id,
        public IsActive $isActive,
        public Title $title,
        public Slug $slug,
        public CreatedAt $createdAt,
        public Description $description = new Description(''),
    ) {
    }

    /** @return array<string, scalar|null> */
    public function asArray(): array
    {
        return [
            'id' => $this->id->toNative(),
            'isActive' => $this->isActive->toNative(),
            'title' => $this->title->toNative(),
            'slug' => $this->slug->toNative(),
            'description' => $this->description->toNative(),
            'createdAt' => $this->createdAt->toNative(),
        ];
    }
}
