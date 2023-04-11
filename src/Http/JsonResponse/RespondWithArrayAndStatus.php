<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\JsonResponse;

readonly class RespondWithArrayAndStatus implements RespondWith
{
    /**
     * @param array<string, (int|float|string|bool|array|null)> $array
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(
        private array $array = [],
        private int $statusCode = 200,
    ) {
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function asArray(): array
    {
        return $this->array;
    }
}
