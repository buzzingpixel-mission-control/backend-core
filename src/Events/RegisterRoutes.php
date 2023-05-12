<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use MissionControlBackend\Api\Timezone\GetTimezoneListAction;
use MissionControlBackend\Http\AccountApplyRoutesEvent;
use MissionControlBackend\Http\ApiApplyRoutesEvent;
use MissionControlBackend\Http\AuthApplyRoutesEvent;
use MissionControlBackend\Projects\AddEditProject\PatchArchiveProjectAction;
use MissionControlBackend\Projects\AddEditProject\PatchEditProjectAction;
use MissionControlBackend\Projects\AddEditProject\PatchUnArchiveProjectAction;
use MissionControlBackend\Projects\AddEditProject\PostAddProjectAction;
use MissionControlBackend\Projects\GetProjectDetails\GetProjectDetailsBySlugAction;
use MissionControlBackend\Projects\GetProjectsListAction;
use MissionControlBackend\Projects\GetProjectsListArchivedAction;
use MissionControlBackend\Queue\GetQueueListAction;
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
        GetQueueListAction::registerRoute($event);
        GetProjectsListAction::registerRoute($event);
        GetTimezoneListAction::registerRoute($event);
        PostAddProjectAction::registerRoute($event);
        PatchEditProjectAction::registerRoute($event);
        PatchArchiveProjectAction::registerRoute($event);
        PatchUnArchiveProjectAction::registerRoute($event);
        GetProjectDetailsBySlugAction::registerRoute($event);
        GetProjectsListArchivedAction::registerRoute($event);
    }

    public function onApplyAuthRoutes(AuthApplyRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event);
    }
}
