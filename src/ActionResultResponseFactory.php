<?php

declare(strict_types=1);

namespace MissionControlBackend;

use MissionControlBackend\Http\JsonResponse\RespondWith;
use MissionControlBackend\Http\JsonResponse\RespondWithArrayAndStatus;

use function implode;

class ActionResultResponseFactory
{
    public function createResponse(ActionResult $result): RespondWith
    {
        if ($result->success) {
            return new RespondWithArrayAndStatus();
        }

        return new RespondWithArrayAndStatus(
            [
                'success' => false,
                'message' => implode('. ', $result->message),
            ],
            500,
        );
    }
}
