<?php

declare(strict_types=1);

namespace MissionControlBackend\Cli;

use MissionControlBackend\CoreConfig;
use MissionControlBackend\ErrorLogging\ErrorLogFactory;
use MissionControlBackend\ErrorLogging\SaveErrorLogFactory;
use Silly\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

use function is_numeric;

readonly class Run
{
    public function __construct(
        private Application $app,
        private CoreConfig $coreConfig,
        private ErrorLogFactory $errorLogFactory,
        private SaveErrorLogFactory $saveErrorLogFactory,
    ) {
    }

    public function runApplication(
        InputInterface|null $input = null,
        OutputInterface|null $output = null,
    ): void {
        $this->app->setAutoExit(false);
        $this->app->setCatchExceptions(false);

        try {
            $this->app->run($input, $output);
        } catch (Throwable $exception) {
            $errorLog = $this->errorLogFactory->create($exception);

            $this->saveErrorLogFactory->create($errorLog)->save(
                $errorLog,
            );

            if ($this->coreConfig->useWhoopsErrorHandling) {
                throw $exception;
            }

            $this->renderException($exception, $output);

            $exitCode = $exception->getCode();

            if (is_numeric($exitCode)) {
                $exitCode = (int) $exitCode;

                if ($exitCode <= 0) {
                    $exitCode = 1;
                }
            } else {
                $exitCode = 1;
            }

            if ($exitCode > 255) {
                $exitCode = 255;
            }

            exit($exitCode);
        }
    }

    private function renderException(
        Throwable $exception,
        OutputInterface|null $output,
    ): void {
        $output ??= new ConsoleOutput();

        if ($output instanceof ConsoleOutputInterface) {
            $this->app->renderThrowable(
                $exception,
                $output->getErrorOutput(),
            );
        } else {
            $this->app->renderThrowable(
                $exception,
                $output,
            );
        }
    }
}
