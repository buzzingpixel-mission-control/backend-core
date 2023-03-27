<?php

declare(strict_types=1);

namespace MissionControlBackend\Templating;

use Qiq\Escape;
use Qiq\HelperLocator;
use Qiq\Template;
use Qiq\TemplateLocator;

class TemplatingEngineFactory
{
    public function create(): TemplatingEngine
    {
        return new TemplatingEngine(new Template(
            new TemplateLocator(
                ['/'],
                '.phtml',
                new Compiler(),
            ),
            HelperLocator::new(
                new Escape('utf-8'),
            ),
        ));
    }
}
