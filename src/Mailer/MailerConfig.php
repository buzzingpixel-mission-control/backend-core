<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

readonly class MailerConfig
{
    public function __construct(
        public string $systemFromAddress,
        public string $systemFromName,
        public string $protocol = 'smtp',
        public string $user = '',
        public string $password = '',
        public string $host = '',
        public string $port = '',
    ) {
    }
}
