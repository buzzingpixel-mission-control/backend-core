<?php

declare(strict_types=1);

namespace MissionControlBackend;

class BootConfig
{
    public function __construct(public bool $useWhoopsErrorHandling)
    {
    }
}
