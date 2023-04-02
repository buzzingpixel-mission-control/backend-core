<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use MissionControlBackend\Cli\ApplyCliCommandsEvent;
use Phinx\Console\Command\Status;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

readonly class MigrateStatusCommand
{
    public static function register(ApplyCliCommandsEvent $event): void
    {
        $event->addCommand('migrate:status', self::class);
    }

    public function __construct(
        private Status $status,
        private ConsoleOutput $output,
    ) {
    }

    public function __invoke(): int
    {
        return $this->status->run(
            new ArrayInput(['--environment' => 'default']),
            $this->output,
        );
    }
}
