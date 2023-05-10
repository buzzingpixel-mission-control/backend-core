<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use Spatie\Cloneable\Cloneable;

use function array_map;
use function array_merge;
use function array_values;
use function count;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class AttachmentFields
{
    use Cloneable;

    /** @var AttachmentField[] */
    public array $fields;

    /** @param AttachmentField[] $fields */
    public function __construct(array $fields = [])
    {
        $this->fields = array_values(array_map(
            static fn (AttachmentField $a) => $a,
            $fields,
        ));
    }

    public function withField(AttachmentField $field): static
    {
        return $this->with(fields: array_merge(
            $this->fields,
            [$field],
        ));
    }

    /** @phpstan-ignore-next-line */
    public function asArray(): array
    {
        return array_map(
            static fn (AttachmentField $f) => $f->asArray(),
            $this->fields,
        );
    }

    /** @phpstan-ignore-next-line */
    public function asArrayOrNull(): array|null
    {
        if (count($this->fields) < 1) {
            return null;
        }

        return $this->asArray();
    }
}
