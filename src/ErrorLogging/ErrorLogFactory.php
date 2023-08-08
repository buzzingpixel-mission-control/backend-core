<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use MissionControlBackend\ErrorLogging\Persistence\FindErrorLogParameters;
use MissionControlBackend\ErrorLogging\ValueObjects\File;
use MissionControlBackend\ErrorLogging\ValueObjects\Line;
use MissionControlBackend\ErrorLogging\ValueObjects\Message;
use MissionControlBackend\ErrorLogging\ValueObjects\Trace;
use Psr\Clock\ClockInterface;
use Throwable;

use function implode;
use function md5;

readonly class ErrorLogFactory
{
    public function __construct(
        private ClockInterface $clock,
        private ErrorLogRepository $repository,
    ) {
    }

    public function create(Throwable $exception): ErrorLog|NewErrorLog
    {
        $hash = md5(implode('_', [
            $exception->getMessage(),
            $exception->getFile(),
            (string) $exception->getLine(),
            $exception->getTraceAsString(),
        ]));

        $existing = $this->repository->findOneOrNull(
            FindErrorLogParameters::create()
                ->withHash($hash),
        );

        if ($existing === null) {
            return new NewErrorLog(
                Message::fromNative($exception->getMessage()),
                File::fromNative($exception->getFile()),
                Line::fromNative($exception->getLine()),
                Trace::fromNative($exception->getTraceAsString()),
            );
        }

        return $existing->withLastErrorAt($this->clock->now());
    }
}
