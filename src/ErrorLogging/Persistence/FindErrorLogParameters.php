<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\Persistence;

use MissionControlBackend\Persistence\CustomQueryParams;
use MissionControlBackend\Persistence\FetchParameters;
use MissionControlBackend\Persistence\Sort;
use MissionControlBackend\Persistence\StringCollection;

use function array_merge;
use function implode;

readonly class FindErrorLogParameters extends FetchParameters
{
    public static function create(): self
    {
        return new self();
    }

    public function __construct(
        public StringCollection|null $hashes = null,
        public StringCollection|null $notHashes = null,
        StringCollection|null $ids = null,
        StringCollection|null $notIds = null,
        int|null $limit = null,
        int|null $offset = null,
        string|null $orderBy = null,
        Sort|null $sort = null,
    ) {
        parent::__construct(
            $ids,
            $notIds,
            $limit,
            $offset,
            $orderBy,
            $sort,
        );
    }

    public static function getTableName(): string
    {
        return ErrorLogTable::TABLE_NAME;
    }

    public function tableName(): string
    {
        return ErrorLogTable::TABLE_NAME;
    }

    public function withHash(string $title): static
    {
        $hashes = $this->hashes ?? new StringCollection();

        return $this->with(hashes: $hashes->withString($title));
    }

    public function withNotHash(string $notHash): static
    {
        $notHashes = $this->hashes ?? new StringCollection();

        return $this->with(hashes: $notHashes->withString($notHash));
    }

    public function buildQuery(
        callable|null $buildCustomQuerySection = null,
    ): CustomQueryParams {
        $internalCustomQuery = $this->buildInternalCustomQuery();

        if ($buildCustomQuerySection === null) {
            $buildCustomQuerySection = $internalCustomQuery;
        } else {
            $build = $buildCustomQuerySection();

            $buildCustomQuerySection = new CustomQueryParams(
                $build->query . ' ' . $internalCustomQuery->query,
                array_merge(
                    $build->params,
                    $internalCustomQuery->params,
                ),
            );
        }

        return parent::buildQuery(
            static fn () => $buildCustomQuerySection,
        );
    }

    private function buildInternalCustomQuery(): CustomQueryParams
    {
        $params = [];

        $query = [];

        if (
            $this->hashes !== null &&
            $this->hashes->count() > 0
        ) {
            $in = [];

            $i = 1;

            $this->hashes->map(
                static function (string $hash) use (
                    &$i,
                    &$in,
                    &$params,
                ): void {
                    $key = 'hash_' . $i;

                    $in[] = ':' . $key;

                    $params[$key] = $hash;

                    $i++;
                },
            );

            $query[] = 'AND hash IN (' .
                implode(',', $in) .
                ')';
        }

        if (
            $this->notHashes !== null &&
            $this->notHashes->count() > 0
        ) {
            $in = [];

            $i = 1;

            $this->notHashes->map(
                static function (string $hash) use (
                    &$i,
                    &$in,
                    &$params,
                ): void {
                    $key = 'not_hash_' . $i;

                    $in[] = ':' . $key;

                    $params[$key] = $hash;

                    $i++;
                },
            );

            $query[] = 'AND hash NOT IN (' .
                implode(',', $in) .
                ')';
        }

        return new CustomQueryParams(
            implode(' ', $query),
            $params,
        );
    }
}
