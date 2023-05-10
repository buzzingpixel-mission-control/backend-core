<?php

declare(strict_types=1);

namespace MissionControlBackend\Slack\Chat;

use Spatie\Cloneable\Cloneable;

use function array_filter;

// phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

readonly class Attachment
{
    use Cloneable;

    public function __construct(
        public string|null $authorIcon = null,
        public string|null $authorLink = null,
        public string|null $authorName = null,
        public string|null $color = null,
        public string|null $fallback = null,
        public AttachmentFields $fields = new AttachmentFields(),
        public string|null $footer = null,
        public string|null $footerIcon = null,
        public string|null $imageUrl = null,
        public string|null $pretext = null,
        public string|null $text = null,
        public string|null $thumbUrl = null,
        public string|null $title = null,
        public string|null $titleLink = null,
        public string|null $ts = null,
        public AttachmentActions $actions = new AttachmentActions(),
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function asArray(): array
    {
        return array_filter(
            [
                'author_icon' => $this->authorIcon,
                'author_link' => $this->authorLink,
                'author_name' => $this->authorName,
                'color' => $this->color,
                'fallback' => $this->fallback,
                'fields' => $this->fields->asArrayOrNull(),
                'footer' => $this->footer,
                'footer_icon' => $this->footerIcon,
                'image_url' => $this->imageUrl,
                'pretext' => $this->pretext,
                'text' => $this->text,
                'thumb_url' => $this->thumbUrl,
                'title' => $this->title,
                'title_link' => $this->titleLink,
                'ts' => $this->ts,
                'actions' => $this->actions->asArrayOrNull(),
            ],
            static fn (mixed $item) => $item !== null,
        );
    }

    public function withAuthorIcon(string|null $value): static
    {
        return $this->with(authorIcon: $value);
    }

    public function withAuthorLink(string|null $value): static
    {
        return $this->with(authorLink: $value);
    }

    public function withAuthorName(string|null $value): static
    {
        return $this->with(authorName: $value);
    }

    public function withColor(string|null $value): static
    {
        return $this->with(color: $value);
    }

    public function withFallback(string|null $value): static
    {
        return $this->with(fallback: $value);
    }

    public function withField(AttachmentField $value): static
    {
        return $this->with(fields: $this->fields->withField($value));
    }

    public function withFooter(string|null $value): static
    {
        return $this->with(footer: $value);
    }

    public function withFooterIcon(string|null $value): static
    {
        return $this->with(footerIcon: $value);
    }

    public function withImageUrl(string|null $value): static
    {
        return $this->with(imageUrl: $value);
    }

    public function withPretext(string|null $value): static
    {
        return $this->with(pretext: $value);
    }

    public function withText(string|null $value): static
    {
        return $this->with(text: $value);
    }

    public function withThumbUrl(string|null $value): static
    {
        return $this->with(thumbUrl: $value);
    }

    public function withTitle(string|null $value): static
    {
        return $this->with(title: $value);
    }

    public function withTitleLink(string|null $value): static
    {
        return $this->with(titleLink: $value);
    }

    public function withTs(string|null $value): static
    {
        return $this->with(ts: $value);
    }

    public function withAction(AttachmentAction $action): static
    {
        return $this->with(actions: $this->actions->withAction($action));
    }
}
