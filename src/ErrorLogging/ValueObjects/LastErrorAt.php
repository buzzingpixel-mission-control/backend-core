<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\ValueObjects;

use Funeralzone\ValueObjects\ValueObject;
use MissionControlBackend\Persistence\ValueObjects\DbDateTime;

class LastErrorAt implements ValueObject
{
    use DbDateTime;
}
