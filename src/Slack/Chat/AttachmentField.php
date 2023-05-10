<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use Spatie\Cloneable\Cloneable;

use function array_filter;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class AttachmentField
{
    use Cloneable;

    public function __construct(
        public string|null $title = null,
        public string|null $value = null,
        public bool $short = false,
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function asArray(): array
    {
        return array_filter(
            [
                'title' => $this->title,
                'value' => $this->value,
                'short' => $this->short,
            ],
            static fn (mixed $item) => $item !== null,
        );
    }
}
