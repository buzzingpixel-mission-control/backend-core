<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class AttachmentAction
{
    public function __construct(
        public string $text,
        public string $url,
        public string $type = 'button',
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function asArray(): array
    {
        return [
            'text' => $this->text,
            'url' => $this->url,
            'type' => $this->type,
        ];
    }
}
