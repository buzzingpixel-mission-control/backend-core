<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack;

readonly class SlackClientConfig
{
    public function __construct(
        public string $slackToken,
        public string $defaultChannel,
    ) {
    }
}
