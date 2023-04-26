<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use MissionControlBackend\Api\Timezone\GetTimezoneListAction;
use MissionControlBackend\Http\AccountApplyRoutesEvent;
use MissionControlBackend\Http\ApiApplyRoutesEvent;
use MissionControlBackend\Http\AuthApplyRoutesEvent;
use MissionControlBackend\Projects\AddEditProject\PostAddProjectAction;
use MissionControlBackend\Projects\GetProjectsListAction;
use MissionControlBackend\Templating\GetVendorCssJs;

class RegisterRoutes
{
    public function onApplyAccountRoutes(AccountApplyRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event);
    }

    public function onApplyApiRoutes(ApiApplyRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event);
        GetTimezoneListAction::registerRoute($event);
        GetProjectsListAction::registerRoute($event);
        PostAddProjectAction::registerRoute($event);
    }

    public function onApplyAuthRoutes(AuthApplyRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event);
    }
}
