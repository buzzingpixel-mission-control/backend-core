<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\ValueObjects;

use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;

class Slug implements ValueObject
{
    use StringTrait;
}
