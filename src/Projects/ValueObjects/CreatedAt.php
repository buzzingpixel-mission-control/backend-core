<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\ValueObjects;

use Funeralzone\ValueObjects\ValueObject;
use MissionControlBackend\Persistence\ValueObjects\DbDateTime;

class CreatedAt implements ValueObject
{
    use DbDateTime;
}
