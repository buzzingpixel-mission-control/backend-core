<?php

declare(strict_types=1);

namespace MissionControlBackend\Templating;

use Qiq\Template;
use stdClass;

// phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification

readonly class TemplatingEngine
{
    public function __construct(private Template $template)
    {
    }

    public function render(): string
    {
        return ($this->template)();
    }

    public function extends(string $path): self
    {
        $this->template->extends($path);

        return $this;
    }

    public function hasTemplate(string $path): bool
    {
        return $this->template->hasTemplate($path);
    }

    public function addVariable(string $name, mixed $value): self
    {
        $this->addData([$name => $value]);

        return $this;
    }

    /** @phpstan-ignore-next-line */
    public function addData(iterable $data): self
    {
        $this->template->addData($data);

        return $this;
    }

    /** @phpstan-ignore-next-line */
    public function setData(array|stdClass $data): self
    {
        $this->template->setData($data);

        return $this;
    }

    public function setLayout(string|null $path): self
    {
        $this->template->setLayout($path);

        return $this;
    }

    public function setView(string|null $path): self
    {
        $this->template->setView($path);

        return $this;
    }
}
