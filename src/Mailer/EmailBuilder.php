<?php

declare(strict_types=1);

namespace MissionControlBackend\Mailer;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\AbstractPart;
use Symfony\Component\Mime\Part\DataPart;

readonly class EmailBuilder
{
    private Email $email;

    public function __construct(private SystemFromAddress $systemFromAddress)
    {
        $this->email = new Email();

        $this->email->from($this->systemFromAddress->address);
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function subject(string $subject): self
    {
        $this->email->subject($subject);

        return $this;
    }

    public function getSubject(): string|null
    {
        return $this->email->getSubject();
    }

    public function replyTo(Address|string ...$addresses): self
    {
        $this->email->replyTo(...$addresses);

        return $this;
    }

    public function addReplyTo(Address|string ...$addresses): self
    {
        $this->email->addReplyTo(...$addresses);

        return $this;
    }

    /** @return Address[] */
    public function getReplyTo(): array
    {
        return $this->email->getReplyTo();
    }

    public function to(Address|string ...$addresses): self
    {
        $this->email->to(...$addresses);

        return $this;
    }

    public function addTo(Address|string ...$addresses): self
    {
        $this->email->addTo(...$addresses);

        return $this;
    }

    /** @return Address[] */
    public function getTo(): array
    {
        return $this->email->getTo();
    }

    public function cc(Address|string ...$addresses): self
    {
        $this->email->cc(...$addresses);

        return $this;
    }

    public function addCc(Address|string ...$addresses): self
    {
        $this->email->addCc(...$addresses);

        return $this;
    }

    /** @return Address[] */
    public function getCc(): array
    {
        return $this->email->getCc();
    }

    public function bcc(Address|string ...$addresses): self
    {
        $this->email->bcc(...$addresses);

        return $this;
    }

    public function addBcc(Address|string ...$addresses): self
    {
        $this->email->addBcc(...$addresses);

        return $this;
    }

    /** @return Address[] */
    public function getBcc(): array
    {
        return $this->email->getBcc();
    }

    /**
     * Sets the priority of this message.
     *
     * The value is an integer where 1 is the highest priority and 5 is the lowest.
     */
    public function priority(int $priority): self
    {
        $this->email->priority($priority);

        return $this;
    }

    /**
     * Get the priority of this message.
     *
     * The returned value is an integer where 1 is the highest priority and 5
     * is the lowest.
     */
    public function getPriority(): int
    {
        return $this->email->getPriority();
    }

    /**
     * @param resource|string|null $body
     *
     * @return $this
     */
    public function text($body, string $charset = 'utf-8'): self
    {
        $this->email->text($body, $charset);

        return $this;
    }

    /** @return resource|string|null */
    public function getTextBody()
    {
        return $this->email->getTextBody();
    }

    public function getTextCharset(): string|null
    {
        return $this->email->getTextCharset();
    }

    /** @param resource|string|null $body */
    public function html($body, string $charset = 'utf-8'): self
    {
        $this->email->html($body, $charset);

        return $this;
    }

    /** @return resource|string|null */
    public function getHtmlBody()
    {
        return $this->email->getHtmlBody();
    }

    public function getHtmlCharset(): string|null
    {
        return $this->email->getHtmlCharset();
    }

    /** @param resource|string $body */
    public function attach(
        $body,
        string|null $name = null,
        string|null $contentType = null,
    ): self {
        $this->email->attach(
            $body,
            $name,
            $contentType,
        );

        return $this;
    }

    public function attachFromPath(
        string $path,
        string|null $name = null,
        string|null $contentType = null,
    ): self {
        $this->email->attachFromPath(
            $path,
            $name,
            $contentType,
        );

        return $this;
    }

    /** @param resource|string $body */
    public function embed(
        $body,
        string|null $name = null,
        string|null $contentType = null,
    ): self {
        $this->email->embed(
            $body,
            $name,
            $contentType,
        );

        return $this;
    }

    public function embedFromPath(
        string $path,
        string|null $name = null,
        string|null $contentType = null,
    ): self {
        $this->email->embedFromPath(
            $path,
            $name,
            $contentType,
        );

        return $this;
    }

    public function addPart(DataPart $part): self
    {
        $this->email->addPart($part);

        return $this;
    }

    /** @return DataPart[] */
    public function getAttachments(): array
    {
        return $this->email->getAttachments();
    }

    public function getBody(): AbstractPart
    {
        return $this->email->getBody();
    }
}
