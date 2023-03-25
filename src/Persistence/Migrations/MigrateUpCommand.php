<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use Phinx\Console\Command\Migrate;
use Silly\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

readonly class MigrateUpCommand
{
    public static function register(Application $app): void
    {
        $app->command('migrate:up', self::class);
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
