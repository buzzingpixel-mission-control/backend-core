<?php

declare(strict_types=1);

namespace MissionControlBackend\Http;

readonly class HttpRoutesConfig
{
    public function __construct(
        public string $authHost,
        public string $accountHost,
    ) {
    }
}
