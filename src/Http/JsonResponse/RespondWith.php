<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\JsonResponse;

interface RespondWith
{
    public function statusCode(): int;

    /**
     * @return array<string, (int|float|string|bool|array|null)>
     *
     * @phpstan-ignore-next-line
     */
    public function asArray(): array;
}
