<?php

declare(strict_types=1);

namespace MissionControlBackend\Templating;

use Composer\Autoload\ClassLoader;
use MissionControlBackend\Http\ApplyRoutesEvent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use Slim\Exception\HttpNotFoundException;

use function dirname;
use function file_exists;
use function file_get_contents;
use function pathinfo;

class GetVendorCssJs
{
    public static function registerRoute(ApplyRoutesEvent $event): void
    {
        $event->get(
            '/vendor[/{segment1}[/{segment2}[/{segment3}[/{segment4}[/{segment5}[/{segment6}[/{segment7}[/{segment8}[/{segment9}[/{segment10}]]]]]]]]]]',
            self::class,
        );
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $path = $request->getUri()->getPath();

        $pathParts = pathinfo($path);

        $ext = ($pathParts['extension'] ?? '');

        if ($ext !== 'css' && $ext !== 'js') {
            throw new HttpNotFoundException($request);
        }

        $reflection = new ReflectionClass(ClassLoader::class);

        $projectDir = dirname(
            (string) $reflection->getFileName(),
            3,
        );

        $filePath = $projectDir . $path;

        if (! file_exists($filePath)) {
            throw new HttpNotFoundException($request);
        }

        $response = $response->withHeader(
            'Content-Type',
            $ext === 'css' ? 'text/css' : 'application/javascript',
        );

        $response->getBody()->write(
            (string) file_get_contents($filePath),
        );

        return $response;
    }
}
