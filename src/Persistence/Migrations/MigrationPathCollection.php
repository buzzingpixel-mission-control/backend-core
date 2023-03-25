<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use function array_map;
use function array_values;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

class MigrationPathCollection
{
    /** @var MigrationPath[] */
    public array $paths;

    /** @param MigrationPath[] $paths */
    public function __construct(array $paths = [])
    {
        $this->paths = array_values(array_map(
            static fn (MigrationPath $p) => $p,
            $paths,
        ));
    }

    /** @phpstan-ignore-next-line */
    public function map(callable $callback): array
    {
        return array_map($callback, $this->paths);
    }

    /** @return string[] */
    public function asPrimitiveArray(): array
    {
        return $this->map(static fn (MigrationPath $p) => $p->path);
    }

    public function addPath(MigrationPath $path): self
    {
        $this->paths[] = $path;

        return $this;
    }

    public function addPathFromString(string $path): self
    {
        $this->addPath(new MigrationPath($path));

        return $this;
    }
}
