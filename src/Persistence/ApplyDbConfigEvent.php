<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

class ApplyDbConfigEvent
{
    public function __construct(public DbConfig|null $config = null)
    {
    }

    public function addConfig(DbConfig $config): self
    {
        $this->config = $config;

        return $this;
    }
}
