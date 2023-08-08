<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use function array_map;
use function array_values;

class ErrorLogCollection
{
    /** @var ErrorLog[] */
    public array $entities;

    /** @param ErrorLog[] $entities */
    public function __construct(array $entities = [])
    {
        $this->entities = array_values(array_map(
            static fn (ErrorLog $e) => $e,
            $entities,
        ));
    }

    public function first(): ErrorLog
    {
        return $this->entities[0];
    }

    public function firstOrNull(): ErrorLog|null
    {
        return $this->entities[0] ?? null;
    }

    /** @return mixed[] */
    public function map(callable $callback): array
    {
        return array_values(array_map(
            $callback,
            $this->entities,
        ));
    }

    /** @return array<array-key, array<string, scalar|null>> */
    public function asArray(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->map(static fn (ErrorLog $e) => $e->asArray());
    }
}
