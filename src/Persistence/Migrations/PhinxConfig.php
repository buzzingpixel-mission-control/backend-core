<?php

declare(strict_types=1);

namespace MissionControlBackend\Persistence\Migrations;

use Phinx\Config\Config;
use Phinx\Config\ConfigInterface;
use Psr\Container\ContainerInterface;
use RuntimeException;

use function is_array;

readonly class PhinxConfig implements ConfigInterface
{
    public function __construct(
        private ContainerInterface $container,
        private DbConfig $dbConfig,
        private MigrationPathCollection $paths,
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function getEnvironments(): array|null
    {
        return [
            'default_environment' => 'default',
            'default' => [
                'migration_table' => 'migrations',
                'adapter' => $this->dbConfig->adapter->toString(),
                'host' => $this->dbConfig->host,
                'name' => $this->dbConfig->name,
                'user' => $this->dbConfig->user,
                'pass' => $this->dbConfig->pass,
                'port' => $this->dbConfig->port,
                'charset' => $this->dbConfig->charset,
                'collation' => $this->dbConfig->collation,
            ],
        ];
    }

    /** @phpstan-ignore-next-line */
    public function getEnvironment(string $name): array|null
    {
        $env = $this->getEnvironments()[$name] ?? null;

        if (! is_array($env)) {
            return null;
        }

        return $env;
    }

    public function hasEnvironment(string $name): bool
    {
        $env = $this->getEnvironment($name);

        return $env !== null;
    }

    public function getDefaultEnvironment(): string
    {
        return 'default';
    }

    public function getAlias(string $alias): string|null
    {
        throw new RuntimeException(
            'PhinxConfig::getAlias() is not implemented',
        );
    }

    /** @inheritDoc */
    public function getAliases(): array
    {
        throw new RuntimeException(
            'PhinxConfig::getAliases() is not implemented',
        );
    }

    public function getConfigFilePath(): string|null
    {
        throw new RuntimeException(
            'PhinxConfig::getConfigFilePath() is not implemented',
        );
    }

    /** @inheritDoc */
    public function getMigrationPaths(): array
    {
        return $this->paths->asPrimitiveArray();
    }

    /** @inheritDoc */
    public function getSeedPaths(): array
    {
        return [];
    }

    public function getTemplateFile(): false|string
    {
        return __DIR__ . '/Migration.php.template';
    }

    public function getTemplateClass(): false|string
    {
        return false;
    }

    public function getTemplateStyle(): string
    {
        return Config::TEMPLATE_STYLE_CHANGE;
    }

    public function getContainer(): ContainerInterface|null
    {
        return $this->container;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function getDataDomain(): array
    {
        return [];
    }

    public function getVersionOrder(): string
    {
        return Config::VERSION_ORDER_EXECUTION_TIME;
    }

    public function isVersionOrderCreationTime(): bool
    {
        return true;
    }

    public function getBootstrapFile(): bool|string
    {
        return false;
    }

    public function getMigrationBaseClassName(
        bool $dropNamespace = true,
    ): string {
        return ChangeMigration::class;
    }

    public function getSeedBaseClassName(bool $dropNamespace = true): string
    {
        throw new RuntimeException(
            'PhinxConfig::getSeedBaseClassName() is not implemented',
        );
    }

    public function getSeedTemplateFile(): string|null
    {
        throw new RuntimeException(
            'PhinxConfig::getSeedTemplateFile() is not implemented',
        );
    }

    public function offsetExists(mixed $offset): bool
    {
        throw new RuntimeException(
            'PhinxConfig::offsetExists() is not implemented',
        );
    }

    public function offsetGet(mixed $offset): mixed
    {
        throw new RuntimeException(
            'PhinxConfig::offsetGet() is not implemented',
        );
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new RuntimeException(
            'PhinxConfig::offsetSet() is not implemented',
        );
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new RuntimeException(
            'PhinxConfig::offsetUnset() is not implemented',
        );
    }
}
