<?php

declare(strict_types=1);

namespace MissionControlBackend\Csrf;

use Slim\Csrf\Guard;

readonly class CsrfTokenGenerator
{
    public function __construct(private Guard $csrf)
    {
    }

    public function generate(): CsrfToken
    {
        $this->csrf->generateToken();

        return new CsrfToken(
            $this->csrf->getTokenNameKey(),
            (string) $this->csrf->getTokenName(),
            $this->csrf->getTokenValueKey(),
            (string) $this->csrf->getTokenValue(),
        );
    }
}
