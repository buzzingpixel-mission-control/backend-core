# Mission Control Backend Core

This package contains Mission Control's base set up functionality for the backend.

Use composer to require it into your project.

```shell
composer require buzzingpixel/mission-control-backend-core
```

## HTTP

In your web entry point front controller (usually `index.php` in the public directory), boot up and run the HTTP application like so:

```php
<?php

declare(strict_types=1);

use MissionControlBackend\Boot;
use MissionControlBackendApp\Config\BootHttpMiddlewareConfigFactory;
use MissionControlBackendApp\Config\CoreConfigFactory;
use MissionControlBackendApp\Config\Dependencies\DependencyBindings;
use MissionControlBackendApp\Config\Events\EventRegistration;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Boot())
    // The first argument of `start` must be an instance of
    // `\MissionControlBackend\CoreConfig` and is required
    ->start((new CoreConfigFactory())->create())
    // The first argument of `buildContainer` accepts a callable that receives
    // an instance of `\MissionControlBackend\ContainerBindings` which you can
    // use to register container bindings. As you require other mission-control
    // packages, you will need to add that package's dependency bindings here 
    ->buildContainer([DependencyBindings::class, 'register'])
    // The first argument of `registerEvents` accepts a callable that receives
    // an instance of `\Crell\Tukio\OrderedProviderInterface` which you can use
    // to register events. As you require other mission-control packages, you
    // will need to add that package's event bindings here
    ->registerEvents([EventRegistration::class, 'register'])
    ->buildHttpApplication()
    ->applyRoutes()
    // The first argument of `applyMiddleware` must be an instance of
    // `\MissionControlBackend\Http\BootHttpMiddlewareConfig` and is required
    ->applyMiddleware((new BootHttpMiddlewareConfigFactory())->create())
    ->runApplication();
```

As you can see from the example, certain parts of the boot process accept or require arguments, it's up to you how to implement those. See the Dev environment for a working example: https://github.com/buzzingpixel-mission-control/dev

## CLI

In your CLI entry point, boot up and run the cli application like so:

```php
#!/usr/bin/env php
<?php

use MissionControlBackend\Boot;
use MissionControlBackendApp\Config\CoreConfigFactory;
use MissionControlBackendApp\Config\Dependencies\DependencyBindings;
use MissionControlBackendApp\Config\Events\EventRegistration;

require __DIR__ . '/vendor/autoload.php';

(new Boot())
    // The first argument of `start` must be an instance of
    // `\MissionControlBackend\CoreConfig` and is required. This is exactly the
    // same as above in the web entry point
    ->start((new CoreConfigFactory)->create())
    // The first argument of `buildContainer` accepts a callable that receives
    // an instance of `\MissionControlBackend\ContainerBindings` which you can
    // use to register container bindings. As you require other mission-control
    // packages, you will need to add that packages dependency bindings here.
    // This is exactly the same as above in the web entry point
    ->buildContainer([DependencyBindings::class, 'register'])
    // The first argument of `registerEvents` accepts a callable that receives
    // an instance of `\Crell\Tukio\OrderedProviderInterface` which you can use
    // to register events. As you require other mission-control packages, you
    // will need to add that package's event bindings here. This is exactly the
    // same as above in the web entry point
    ->registerEvents([EventRegistration::class, 'register'])
    ->buildCliApplication()
    ->applyCommands()
    ->runApplication();
```

## Dependencies and events

There are a number of dependencies and events needed. As you start up the application for the first time, the exception messages should be pretty clear what you need to set up as they are encountered. See https://github.com/buzzingpixel-mission-control/dev for a better idea.

This project is primarily for me so, it's hard to muster up the gumption to write full documentation at this time.
