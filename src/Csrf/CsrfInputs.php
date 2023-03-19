<?php

declare(strict_types=1);

namespace MissionControlBackend\Csrf;

use Slim\Csrf\Guard;

use function implode;
use function strtr;

readonly class CsrfInputs
{
    public function __construct(private Guard $csrf)
    {
    }

    public function render(): string
    {
        $this->csrf->generateToken();

        $content = implode("\n", [
            '<input type="hidden" name="{nKey}" value="{name}">',
            '<input type="hidden" name="{vKey}" value="{value}">',
        ]);

        return strtr($content, [
            '{nKey}' => $this->csrf->getTokenNameKey(),
            '{name}' => $this->csrf->getTokenName(),
            '{vKey}' => $this->csrf->getTokenValueKey(),
            '{value}' => $this->csrf->getTokenValue(),
        ]);
    }
}
