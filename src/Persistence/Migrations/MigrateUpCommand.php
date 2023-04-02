<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use MissionControlBackend\Cli\ApplyCliCommandsEvent;
use Phinx\Console\Command\Migrate;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

readonly class MigrateUpCommand
{
    public static function register(ApplyCliCommandsEvent $event): void
    {
        $event->addCommand('migrate:up', self::class);
    }

    public function __construct(
        private Migrate $migrate,
        private ConsoleOutput $output,
    ) {
    }

    public function __invoke(): int
    {
        return $this->migrate->run(
            new ArrayInput(['--environment' => 'default']),
            $this->output,
        );
    }
}
