<?php

declare(strict_types=1);

namespace MissionControlBackend\Events;

use MissionControlBackend\Api\Timezone\GetTimezoneListAction;
use MissionControlBackend\ErrorLogging\DeleteErrorLogAction;
use MissionControlBackend\ErrorLogging\DeleteErrorLogsAction;
use MissionControlBackend\ErrorLogging\GetDetails\GetErrorLogDetailsByIdAction;
use MissionControlBackend\ErrorLogging\GetErrorLogsListAction;
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
use MissionControlBackend\Queue\PostDequeueAllAction;
use MissionControlBackend\Queue\PostDequeueItemAction;
use MissionControlBackend\Queue\QueueDetails\GetQueueDetailsByQueueNameAction;
use MissionControlBackend\Scheduler\GetScheduleList;
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
        GetScheduleList::registerRoute($event);
        GetQueueListAction::registerRoute($event);
        PostDequeueAllAction::registerRoute($event);
        GetProjectsListAction::registerRoute($event);
        GetTimezoneListAction::registerRoute($event);
        PostAddProjectAction::registerRoute($event);
        PostDequeueItemAction::registerRoute($event);
        PatchEditProjectAction::registerRoute($event);
        GetErrorLogsListAction::registerRoute($event);
        DeleteErrorLogsAction::registerRoute($event);
        PatchArchiveProjectAction::registerRoute($event);
        PatchUnArchiveProjectAction::registerRoute($event);
        GetProjectDetailsBySlugAction::registerRoute($event);
        GetProjectsListArchivedAction::registerRoute($event);
        GetQueueDetailsByQueueNameAction::registerRoute($event);
        DeleteErrorLogAction::registerRoute($event);
        GetErrorLogDetailsByIdAction::registerRoute($event);
    }

    public function onApplyAuthRoutes(AuthApplyRoutesEvent $event): void
    {
        GetVendorCssJs::registerRoute($event);
    }
}
