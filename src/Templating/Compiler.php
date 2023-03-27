<?php

declare(strict_types=1);

namespace MissionControlBackend\Templating;

class Compiler implements \Qiq\Compiler\Compiler
{
    public function __invoke(string $source): string
    {
        return $source;
    }

    public function clear(): void
    {
    }
}
