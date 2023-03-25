<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use Phinx\Console\Command\Status;
use Silly\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

readonly class MigrateStatusCommand
{
    public static function register(Application $app): void
    {
        $app->command('migrate:status', self::class);
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
