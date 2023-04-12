<?php

declare(strict_types=1);

namespace MissionControlBackend\Csrf;

readonly class CsrfToken
{
    public function __construct(
        public string $tokenNameKey,
        public string $tokenName,
        public string $tokenValueKey,
        public string $tokenValue,
    ) {
    }
}
