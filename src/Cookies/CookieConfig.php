<?php

declare(strict_types=1);

namespace MissionControlBackend\Cookies;

readonly class CookieConfig
{
    public function __construct(
        public string|null $cookieDomain,
    ) {
    }
}
