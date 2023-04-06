<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

class ApplyMailerConfigEvent
{
    public function __construct(public MailerConfig|null $config = null)
    {
    }

    public function addConfig(MailerConfig $config): self
    {
        $this->config = $config;

        return $this;
    }
}
