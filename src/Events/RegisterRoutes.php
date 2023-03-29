<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use MissionControlBackend\Http\AccountSetRoutesEvent;
use MissionControlBackend\Http\ApiSetRoutesEvent;
use MissionControlBackend\Http\AuthSetRoutesEvent;
use MissionControlBackend\Templating\GetVendorCssJs;

class RegisterRoutes
{
    public function onApplyAccountRoutes(AccountSetRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event->routeCollector);
    }

    public function onApplyApiRoutes(ApiSetRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event->routeCollector);
    }

    public function onApplyAuthRoutes(AuthSetRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event->routeCollector);
    }
}
