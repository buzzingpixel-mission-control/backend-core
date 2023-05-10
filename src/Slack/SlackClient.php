<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack;

use MissionControlBackend\Slack\Chat\Chat;

readonly class SlackClient
{
    public function __construct(public Chat $chat)
    {
    }
}
