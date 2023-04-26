<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\AddEditProject\ValueObjects;

use Assert\Assert;
use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;

class Title implements ValueObject
{
    use StringTrait;

    public function __construct(string $string)
    {
        Assert::that($string)->notEmpty(
            'Title is required',
        );

        $this->string = $string;
    }
}
