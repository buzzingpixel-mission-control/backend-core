<?php

declare(strict_types=1);

namespace MissionControlBackend\Url;

use MissionControlBackend\CoreConfig;

readonly class AuthUrlGenerator implements UrlGenerator
{
    public function __construct(
        private CoreConfig $coreConfig,
        private GenerateUrl $generateUrl,
    ) {
    }

    public function generate(
        string $path,
        QueryParams|null $queryParams = null,
    ): string {
        return $this->generateUrl->fromBasePath(
            $this->coreConfig->authUrl,
            $path,
            $queryParams,
        );
    }
}
