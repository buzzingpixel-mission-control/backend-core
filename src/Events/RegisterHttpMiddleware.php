<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use BuzzingPixel\Minify\MinifyMiddleware;
use MissionControlBackend\Http\SetMiddlewareEvent;

class RegisterHttpMiddleware
{
    public function onSetMiddleware(SetMiddlewareEvent $event): void
    {
        $event->app->add(MinifyMiddleware::class);
    }
}
