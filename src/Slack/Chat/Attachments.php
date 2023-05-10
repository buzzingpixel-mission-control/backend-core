<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use Spatie\Cloneable\Cloneable;

use function array_map;
use function array_merge;
use function array_values;
use function count;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class Attachments
{
    use Cloneable;

    /** @var Attachment[] */
    public array $attachments;

    /** @param Attachment[] $fields */
    public function __construct(array $fields = [])
    {
        $this->attachments = array_values(array_map(
            static fn (Attachment $a) => $a,
            $fields,
        ));
    }

    public function withAttachment(Attachment $attachment): static
    {
        return $this->with(attachments: array_merge(
            $this->attachments,
            [$attachment],
        ));
    }

    /** @phpstan-ignore-next-line */
    public function asArray(): array
    {
        return array_map(
            static fn (Attachment $a) => $a->asArray(),
            $this->attachments,
        );
    }

    /** @phpstan-ignore-next-line */
    public function asArrayOrNull(): array|null
    {
        if (count($this->attachments) < 1) {
            return null;
        }

        return $this->asArray();
    }
}
