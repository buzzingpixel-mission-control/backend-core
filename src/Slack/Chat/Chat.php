<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class Chat
{
    public function __construct(private PostMessage $postMessage)
    {
    }

    /** @phpstan-ignore-next-line */
    public function postMessage(Message $message): array
    {
        return $this->postMessage->post($message);
    }
}
