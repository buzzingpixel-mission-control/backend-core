<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

use BuzzingPixel\Queue\QueueHandler;
use BuzzingPixel\Queue\QueueItem;
use BuzzingPixel\Queue\QueueItemJob;
use BuzzingPixel\Queue\QueueItemJobCollection;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;

readonly class QueueMailer implements MailerInterface
{
    public function __construct(
        private QueueHandler $queueHandler,
        private string $emailQueueName = 'email',
    ) {
    }

    public function send(
        RawMessage $message,
        Envelope|null $envelope = null,
    ): void {
        $this->queueHandler->enqueue(
            new QueueItem(
                'sendEmail',
                'Send Email',
                new QueueItemJobCollection([
                    new QueueItemJob(
                        class: SendEmailFromQueue::class,
                        context: [
                            'message' => $message,
                            'envelope' => $envelope,
                        ],
                    ),
                ]),
            ),
            $this->emailQueueName,
        );
    }
}
