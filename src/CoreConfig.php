<?php

declare(strict_types=1);

namespace MissionControlBackend;

readonly class CoreConfig
{
    public function __construct(
        public string $appUrl,
        public string $apiUrl,
        public string $authUrl,
        public string $accountUrl,
        public string $authHost,
        public string $accountHost,
        public bool $useWhoopsErrorHandling,
    ) {
    }
}
