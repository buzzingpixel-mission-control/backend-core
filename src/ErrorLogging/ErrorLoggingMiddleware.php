<?php

declare(strict_types=1);

namespace MissionControlBackend\ErrorLogging;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

readonly class ErrorLoggingMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ErrorLogFactory $errorLogFactory,
        private SaveErrorLogFactory $saveErrorLogFactory,
    ) {
    }

    /** @throws Throwable */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            $errorLog = $this->errorLogFactory->create($exception);

            $this->saveErrorLogFactory->create($errorLog)->save(
                $errorLog,
            );

            throw $exception;
        }
    }
}
