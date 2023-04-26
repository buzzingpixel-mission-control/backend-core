<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\Persistence;

use function array_map;
use function array_values;
use function count;

readonly class ProjectRecordCollection
{
    /** @var ProjectRecord[] */
    public array $records;

    /** @param ProjectRecord[] $records */
    public function __construct(array $records = [])
    {
        $this->records = array_values(array_map(
            static fn (ProjectRecord $r) => $r,
            $records,
        ));
    }

    public function first(): ProjectRecord
    {
        return $this->records[0];
    }

    public function firstOrNull(): ProjectRecord|null
    {
        return $this->records[0] ?? null;
    }

    /** @return mixed[] */
    public function map(callable $callback): array
    {
        return array_values(array_map(
            $callback,
            $this->records,
        ));
    }

    public function count(): int
    {
        return count($this->records);
    }
}
