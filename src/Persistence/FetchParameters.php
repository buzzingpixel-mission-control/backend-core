<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence;

use Spatie\Cloneable\Cloneable;

use function array_merge;
use function implode;

abstract readonly class FetchParameters
{
    use Cloneable;

    public function __construct(
        public StringCollection|null $ids = null,
        public StringCollection|null $notIds = null,
        public int|null $limit = null,
        public int|null $offset = null,
        public string|null $orderBy = null,
        public Sort|null $sort = null,
    ) {
    }

    abstract public static function getTableName(): string;

    abstract public function tableName(): string;

    public function withId(string $id): static
    {
        $ids = $this->ids ?? new StringCollection();

        return $this->with(
            ids: $ids->with(strings: array_merge(
                $ids->strings,
                [$id],
            )),
        );
    }

    /** @param string[] $ids */
    public function withIds(array $ids): static
    {
        $newIds = $this->ids ?? new StringCollection();

        foreach ($ids as $id) {
            $newIds = $newIds->withString($id);
        }

        return $this->with(ids: $newIds);
    }

    public function withNotId(string $notId): static
    {
        $notIds = $this->notIds ?? new StringCollection();

        return $this->with(
            notIds: $notIds->with(strings: array_merge(
                $notIds->strings,
                [$notId],
            )),
        );
    }

    public function withLimit(int|null $limit): static
    {
        return $this->with(limit: $limit);
    }

    public function withOffset(int|null $offset): static
    {
        return $this->with(offset: $offset);
    }

    public function withOrderBy(string|null $orderBy): static
    {
        return $this->with(orderBy: $orderBy);
    }

    public function withSort(Sort|null $sort): static
    {
        return $this->with(sort: $sort);
    }

    /** @param callable(): CustomQueryParams|null $buildCustomQuerySection */
    public function buildQuery(
        callable|null $buildCustomQuerySection = null,
    ): CustomQueryParams {
        $params = [];

        $query = [
            'SELECT * FROM',
            $this->tableName(),
            'WHERE 1 = 1',
        ];

        if (
            $this->ids !== null &&
            $this->ids->count() > 0
        ) {
            $in = [];

            $i = 1;

            $this->ids->map(
                static function (string $id) use (
                    &$i,
                    &$in,
                    &$params,
                ): void {
                    $key = 'id_' . $i;

                    $in[] = ':' . $key;

                    $params[$key] = $id;

                    $i++;
                },
            );

            $query[] = 'AND id IN (' .
                implode(',', $in) .
                ')';
        }

        if (
            $this->notIds !== null &&
            $this->notIds->count() > 0
        ) {
            $in = [];

            $i = 1;

            $this->notIds->map(
                static function (string $id) use (
                    &$i,
                    &$in,
                    &$params,
                ): void {
                    $key = 'not_id_' . $i;

                    $in[] = ':' . $key;

                    $params[$key] = $id;

                    $i++;
                },
            );

            $query[] = 'AND id NOT IN (' .
                implode(',', $in) .
                ')';
        }

        if ($buildCustomQuerySection !== null) {
            $customQuery = $buildCustomQuerySection();

            $query[] = $customQuery->query;

            $params = array_merge($params, $customQuery->params);
        }

        if ($this->orderBy !== null) {
            $query[] = 'ORDER BY ' . $this->orderBy;

            if ($this->sort !== null) {
                $query[] = $this->sort->name;
            }
        }

        if ($this->limit !== null) {
            $query[] = 'LIMIT ' . $this->limit;
        }

        if ($this->offset !== null) {
            $query[] = 'OFFSET ' . $this->offset;
        }

        return new CustomQueryParams(
            implode(' ', $query),
            $params,
        );
    }
}
