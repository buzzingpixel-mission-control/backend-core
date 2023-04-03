<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

class CustomQueryParams
{
    /** @param mixed[] $params */
    public function __construct(
        public string $query,
        public array $params,
    ) {
    }
}
