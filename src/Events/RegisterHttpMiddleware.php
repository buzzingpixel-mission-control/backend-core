<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use BuzzingPixel\Minify\MinifyMiddleware;
use HttpSoft\Cookie\CookieSendMiddleware;
use MissionControlBackend\ErrorLogging\ErrorLoggingMiddleware;
use MissionControlBackend\Http\ApplyMiddlewareEvent;

class RegisterHttpMiddleware
{
    public function onSetMiddleware(ApplyMiddlewareEvent $event): void
    {
        $event->add(CookieSendMiddleware::class);

        $event->add(MinifyMiddleware::class);

        // This should probably be last
        $event->add(ErrorLoggingMiddleware::class);
    }
}
