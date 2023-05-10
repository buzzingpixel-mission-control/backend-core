<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use MissionControlBackend\Slack\SlackClientConfig;

use function is_array;
use function json_decode;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class PostMessage
{
    public function __construct(
        private Client $guzzle,
        private SlackClientConfig $config,
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function post(Message $message): array
    {
        $response = $this->guzzle->post(
            'https://slack.com/api/chat.postMessage',
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->config->slackToken,
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                RequestOptions::JSON => $message->asArray(
                    $this->config->defaultChannel,
                ),
            ],
        );

        $responseArray = json_decode(
            $response->getBody()->getContents(),
            true,
        );

        if (! is_array($responseArray)) {
            return [];
        }

        return $responseArray;
    }
}
