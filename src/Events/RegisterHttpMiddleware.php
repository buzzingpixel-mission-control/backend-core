<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use BuzzingPixel\Minify\MinifyMiddleware;
use MissionControlBackend\Http\ApplyMiddlewareEvent;

class RegisterHttpMiddleware
{
    public function onSetMiddleware(ApplyMiddlewareEvent $event): void
    {
        $event->add(MinifyMiddleware::class);
    }
}
