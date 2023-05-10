<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use Spatie\Cloneable\Cloneable;

use function array_filter;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

class Message
{
    use Cloneable;

    public function __construct(
        public string|null $channel = null,
        public string|null $text = null,
        public Attachments $attachments = new Attachments(),
        public string|null $iconEmoji = null,
        public string|null $iconUrl = null,
        public bool|null $mrkdwn = null,
        public bool|null $unfurlLinks = null,
        public bool|null $unfurlMedia = null,
        public string|null $username = null,
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function asArray(string|null $defaultChannel = null): array
    {
        // 'attachments' => $this->attachments,
        return array_filter(
            [
                'channel' => $this->channel ?? $defaultChannel,
                'text' => $this->text,
                'attachments' => $this->attachments->asArrayOrNull(),
                'icon_emoji' => $this->iconEmoji,
                'icon_url' => $this->iconUrl,
                'mrkdwn' => $this->mrkdwn,
                'unfurl_links' => $this->unfurlLinks,
                'unfurl_media' => $this->unfurlMedia,
                'username' => $this->username,
            ],
            static fn (mixed $item) => $item !== null,
        );
    }

    public function withChannel(string|null $value): static
    {
        return $this->with(channel: $value);
    }

    public function withText(string|null $value): static
    {
        return $this->with(text: $value);
    }

    public function withAttachment(Attachment $value): static
    {
        return $this->with(attachments: $this->attachments->withAttachment(
            $value,
        ));
    }

    public function withIconEmoji(string|null $value): static
    {
        return $this->with(iconEmoji: $value);
    }

    public function withIconUrl(string|null $value): static
    {
        return $this->with(iconUrl: $value);
    }

    public function withMrkdwn(bool|null $value): static
    {
        return $this->with(mrkdwn: $value);
    }

    public function withUnfurlLinks(bool|null $value): static
    {
        return $this->with(unfurlLinks: $value);
    }

    public function withUnfurlMedia(bool|null $value): static
    {
        return $this->with(unfurlMedia: $value);
    }

    public function withUsername(string|null $value): static
    {
        return $this->with(username: $value);
    }
}
