<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects;

use MissionControlBackend\Projects\ValueObjects\Description;
use MissionControlBackend\Projects\ValueObjects\IsActive;
use MissionControlBackend\Projects\ValueObjects\Slug;
use MissionControlBackend\Projects\ValueObjects\Title;
use Spatie\Cloneable\Cloneable;

readonly class NewProject
{
    use Cloneable;

    public function __construct(
        public Title $title,
        public Slug $slug,
        public IsActive $isActive = new IsActive(true),
        public Description $description = new Description(''),
    ) {
    }
}
