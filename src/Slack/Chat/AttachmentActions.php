<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use Spatie\Cloneable\Cloneable;

use function array_map;
use function array_merge;
use function array_values;
use function count;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

class AttachmentActions
{
    use Cloneable;

    /** @var AttachmentAction[] */
    public array $actions;

    /** @param AttachmentAction[] $actions */
    public function __construct(array $actions = [])
    {
        $this->actions = array_values(array_map(
            static fn (AttachmentAction $a) => $a,
            $actions,
        ));
    }

    public function withAction(AttachmentAction $action): static
    {
        return $this->with(actions: array_merge(
            $this->actions,
            [$action],
        ));
    }

    /** @phpstan-ignore-next-line */
    public function asArray(): array
    {
        return array_map(
            static fn (AttachmentAction $f) => $f->asArray(),
            $this->actions,
        );
    }

    /** @phpstan-ignore-next-line */
    public function asArrayOrNull(): array|null
    {
        if (count($this->actions) < 1) {
            return null;
        }

        return $this->asArray();
    }
}
