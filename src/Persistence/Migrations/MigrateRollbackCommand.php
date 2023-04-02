<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use MissionControlBackend\Cli\ApplyCliCommandsEvent;
use MissionControlBackend\Cli\Question;
use Phinx\Console\Command\Rollback;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

use function implode;

readonly class MigrateRollbackCommand
{
    public static function register(ApplyCliCommandsEvent $event): void
    {
        $event->addCommand('migrate:rollback', self::class);
    }

    public function __construct(
        private Question $question,
        private Rollback $rollback,
        private ConsoleOutput $output,
    ) {
    }

    public function __invoke(): int
    {
        $params = ['--environment' => 'default'];

        $target = $this->question->ask(
            implode('', [
                '<fg=cyan>',
                'Specify target (0 to revert all, blank to revert last): ',
                '</>',
            ]),
        );

        if ($target !== '') {
            $params['--target'] = $target;
        }

        return $this->rollback->run(
            new ArrayInput($params),
            $this->output,
        );
    }
}
