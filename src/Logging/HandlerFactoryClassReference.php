<?php

declare(strict_types=1);

namespace MissionControlBackend\Logging;

use MissionControlBackend\Logging\HandlerFactories\HandlerFactory;

class HandlerFactoryClassReference
{
    /** @param class-string<HandlerFactory> $classString */
    public function __construct(public string $classString)
    {
    }
}
