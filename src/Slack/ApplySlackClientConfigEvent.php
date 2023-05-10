<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack;

class ApplySlackClientConfigEvent
{
    public function __construct(public SlackClientConfig|null $config = null)
    {
    }

    public function addConfig(SlackClientConfig $config): self
    {
        $this->config = $config;

        return $this;
    }
}
