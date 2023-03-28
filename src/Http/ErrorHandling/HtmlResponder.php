<?php

declare(strict_types=1);

namespace MissionControlBackend\Http\ErrorHandling;

use BuzzingPixel\Templating\TemplateEngineFactory;
use MissionControlBackend\CoreConfig;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Throwable;

readonly class HtmlResponder implements Responder
{
    public function __construct(
        private CoreConfig $config,
        private ResponseFactoryInterface $responseFactory,
        private TemplateEngineFactory $templateEngineFactory,
    ) {
    }

    public function respond(Throwable $exception): ResponseInterface
    {
        $templateEngine = $this->templateEngineFactory->create()
            ->templatePath(HtmlResponse::PATH);

        $response = $this->responseFactory->createResponse(500);

        $title = 'Server Error';

        $content = 'An unknown server error has occurred. Click the button to head back to the home page.';

        // 404 instead of 500
        if ($exception instanceof HttpNotFoundException) {
            $response = $response->withStatus(404);

            $title = 'Page Not Found';

            $content = "We couldn't find that page. Click the button to head back to the home page.";
        }

        $templateEngine
            ->addVar('title', $title)
            ->addVar('content', $content)
            ->addVar('homeUrl', $this->config->appUrl);

        $response->getBody()->write($templateEngine->render());

        return $response;
    }
}
