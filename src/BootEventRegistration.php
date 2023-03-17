<?php

declare(strict_types=1);

namespace MissionControlBackend;

use Crell\Tukio\OrderedProviderInterface;
use MissionControlBackend\Events\RegisterEvents;

readonly class BootEventRegistration
{
    public function __construct(
        private BootApplication $bootApplication,
        private OrderedProviderInterface $provider,
    ) {
    }

    public function registerEvents(
        callable|null $register = null,
    ): BootApplication {
        RegisterEvents::register(provider: $this->provider);

        if ($register !== null) {
            $register($this->provider);
        }

        return $this->bootApplication;
    }
}
