<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

use Spatie\Cloneable\Cloneable;

use function array_map;
use function array_values;
use function count;

class StringCollection
{
    use Cloneable;

    /** @var string[] */
    public array $strings;

    /** @param string[] $strings */
    public function __construct(array $strings = [])
    {
        $this->strings = array_values(array_map(
            static fn (string $s) => $s,
            $strings,
        ));
    }

    public function count(): int
    {
        return count($this->strings);
    }

    /** @return mixed[] */
    public function map(callable $callback): array
    {
        return array_values(array_map(
            $callback,
            $this->strings,
        ));
    }
}
