<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use MissionControlBackend\Cli\ApplyCliCommandsEvent;
use MissionControlBackend\Cli\Question;
use MissionControlBackend\Utility\CaseConversion;
use Phinx\Console\Command\Create;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

readonly class MigrateCreateCommand
{
    public static function register(ApplyCliCommandsEvent $event): void
    {
        $event->addCommand('migrate:create', self::class);
    }

    public function __construct(
        private Create $create,
        private Question $question,
        private ConsoleOutput $output,
        private CaseConversion $caseConversion,
    ) {
    }

    public function __invoke(): int
    {
        $name = $this->question->ask(
            question: '<fg=cyan>Provide a migration name: </>',
            required: true,
        );

        $pascaleName = $this->caseConversion->toPascale($name);

        return $this->create->run(
            new ArrayInput(['name' => $pascaleName]),
            $this->output,
        );
    }
}
