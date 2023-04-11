<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\ErrorHandling;

use MissionControlBackend\Http\JsonResponse\IsJsonRequest;
use Psr\Http\Message\ServerRequestInterface;

readonly class ResponderFactory
{
    public function __construct(
        private HtmlResponder $htmlResponder,
        private IsJsonRequest $isJsonRequest,
        private JsonResponder $jsonResponder,
    ) {
    }

    public function createResponder(ServerRequestInterface $request): Responder
    {
        $accept = (string) ($request->getServerParams()['HTTP_ACCEPT'] ?? '');

        $isJsonRequest = $this->isJsonRequest->checkHttpAcceptString(
            httpAccept: $accept,
        );

        if ($isJsonRequest) {
            return $this->jsonResponder;
        }

        return $this->htmlResponder;
    }
}
