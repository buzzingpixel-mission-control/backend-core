<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

readonly class EmailBuilderFactory
{
    public function __construct(private SystemFromAddress $systemFromAddress)
    {
    }

    public function create(): EmailBuilder
    {
        return new EmailBuilder($this->systemFromAddress);
    }
}
