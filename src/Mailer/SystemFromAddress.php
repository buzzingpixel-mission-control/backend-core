<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

use Symfony\Component\Mime\Address;

readonly class SystemFromAddress
{
    public function __construct(public Address $address)
    {
    }
}
