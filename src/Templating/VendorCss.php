<?php

declare(strict_types=1);

namespace MissionControlBackend\Templating;

use function count;

class VendorCss
{
    /** @var string[] */
    private static array $vendorPaths = [];

    public static function addVendorPath(string $path): void
    {
        self::$vendorPaths[] = $path;
    }

    /** @return string[] */
    public static function vendorPaths(): array
    {
        return self::$vendorPaths;
    }

    public static function hasVendorPaths(): bool
    {
        return count(self::$vendorPaths) > 0;
    }
}
