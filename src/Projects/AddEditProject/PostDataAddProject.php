<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\AddEditProject;

use MissionControlBackend\Projects\AddEditProject\ValueObjects\Description;
use MissionControlBackend\Projects\AddEditProject\ValueObjects\Slug;
use MissionControlBackend\Projects\AddEditProject\ValueObjects\Title;

readonly class PostDataAddProject
{
    /** @param string[] $data */
    public static function fromRawPostData(array $data): self
    {
        return new self(
            Title::fromNative($data['title'] ?? ''),
            Slug::fromNative($data['slug'] ?? ''),
            Description::fromNative($data['description'] ?? ''),
        );
    }

    public function __construct(
        public Title $title,
        public Slug $slug,
        public Description $description,
    ) {
    }
}
