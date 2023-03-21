<?php

declare(strict_types=1);

namespace MissionControlBackend\Logging\CustomHandlers;

use Psr\Log\LoggerInterface;
use Stringable;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\ConsoleOutput;

use function method_exists;

readonly class CliLogger implements LoggerInterface
{
    public function __construct(
        private ConsoleOutput $output,
        private FormatterHelper $formatterHelper,
    ) {
    }

    private function logErrorBlockLarge(Stringable|string $message): void
    {
        $formattedInfoBlock = $this->formatterHelper->formatBlock(
            (string) $message,
            'error',
            true,
        );

        $this->output->writeln($formattedInfoBlock);
    }

    private function logErrorBlockSmall(Stringable|string $message): void
    {
        $formattedInfoBlock = $this->formatterHelper->formatBlock(
            (string) $message,
            'error',
        );

        $this->output->writeln($formattedInfoBlock);
    }

    /** @inheritDoc */
    public function emergency(
        Stringable|string $message,
        array $context = [],
    ): void {
        $this->logErrorBlockLarge($message);
    }

    /** @inheritDoc */
    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->logErrorBlockLarge($message);
    }

    /** @inheritDoc */
    public function critical(
        Stringable|string $message,
        array $context = [],
    ): void {
        $this->logErrorBlockSmall($message);
    }

    /** @inheritDoc */
    public function error(Stringable|string $message, array $context = []): void
    {
        $this->output->writeln(
            '<fg=red>' . ((string) $message) . '</>',
        );
    }

    /** @inheritDoc */
    public function warning(
        Stringable|string $message,
        array $context = [],
    ): void {
        $this->output->writeln(
            '<fg=yellow>' . ((string) $message) . '</>',
        );
    }

    /** @inheritDoc */
    public function notice(
        Stringable|string $message,
        array $context = [],
    ): void {
        $this->output->writeln(
            '<fg=magenta>' . ((string) $message) . '</>',
        );
    }

    /** @inheritDoc */
    public function info(Stringable|string $message, array $context = []): void
    {
        $color = $context['color'] ?? 'cyan';

        $asBlock = (bool) ($context['asBlock'] ?? false);

        if ($asBlock) {
            $asBlockStyle = (string) ($context['asBlockStyle'] ?? 'info');

            $asBlockLarge = (bool) ($context['asBlockLarge'] ?? false);

            $formattedInfoBlock = $this->formatterHelper->formatBlock(
                (string) $message,
                $asBlockStyle,
                $asBlockLarge,
            );

            $this->output->writeln($formattedInfoBlock);

            return;
        }

        $this->output->writeln(
            '<fg=' . $color . '>' . ((string) $message) . '</>',
        );
    }

    /** @inheritDoc */
    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->output->writeln(
            '<fg=black>' . ((string) $message) . '</>',
        );
    }

    /** @inheritDoc */
    public function log(
        $level,
        Stringable|string $message,
        array $context = [],
    ): void {
        /** @phpstan-ignore-next-line */
        if (method_exists($this, $level)) {
            /** @phpstan-ignore-next-line */
            $this->{$level}($message, $context);

            return;
        }

        $this->output->writeln(
        /** @phpstan-ignore-next-line */
            '<fg=black>Log Level: ' . ((string) $level) . '</>',
        );

        $this->output->writeln(
            '<fg=black>' . ((string) $message) . '</>',
        );
    }
}
