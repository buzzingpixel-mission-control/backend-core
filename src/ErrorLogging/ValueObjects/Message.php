<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging\ValueObjects;

use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;

class Message implements ValueObject
{
    use StringTrait;
}
