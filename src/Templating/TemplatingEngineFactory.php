<?php

declare(strict_types=1);

namespace MissionControlBackend\Templating;

use Qiq\Template;

class TemplatingEngineFactory
{
    public function create(): TemplatingEngine
    {
        return new TemplatingEngine(template: Template::new(
            paths: '/',
            extension: '.phtml',
        ));
    }
}
