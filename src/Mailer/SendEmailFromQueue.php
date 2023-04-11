<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Mailer\Mailer;

// phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification

readonly class SendEmailFromQueue
{
    public function __construct(private Mailer $mailer)
    {
    }

    /** @phpstan-ignore-next-line */
    public function __invoke(
        /** @phpstan-ignore-next-line */
        #[ArrayShape([
            'message' => '\Symfony\Component\Mime\RawMessage',
            'envelope' => '\Symfony\Component\Mailer\Envelope|null',
        ])]
        array $context,
    ): void {
        $this->mailer->send(
            $context['message'],
            $context['envelope'],
        );
    }
}
