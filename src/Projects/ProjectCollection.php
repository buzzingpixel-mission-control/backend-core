<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects;

use function array_map;
use function array_values;

readonly class ProjectCollection
{
    /** @var Project[] */
    public array $projects;

    /** @param Project[] $projects */
    public function __construct(array $projects = [])
    {
        $this->projects = array_values(array_map(
            static fn (Project $p) => $p,
            $projects,
        ));
    }

    public function first(): Project
    {
        return $this->projects[0];
    }

    public function firstOrNull(): Project|null
    {
        return $this->projects[0] ?? null;
    }

    /** @return mixed[] */
    public function map(callable $callback): array
    {
        return array_values(array_map(
            $callback,
            $this->projects,
        ));
    }

    /** @return array<array-key, array<string, scalar|null>> */
    public function asArray(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->map(static fn (Project $p) => $p->asArray());
    }
}
