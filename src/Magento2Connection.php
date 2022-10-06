<?php

declare(strict_types=1);

namespace Driver\Magento2;

use Driver\Engines\ConnectionInterface;
use Driver\Engines\ConnectionTrait;
use Driver\System\Configuration;

use function realpath;

class Magento2Connection implements ConnectionInterface
{
    use ConnectionTrait;

    private Configuration $configuration;
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification
    private array $settings;
    /** @var array<string, string>|null  */
    private ?array $connectionDetails = null;

    // phpcs:ignore SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
    public function __construct(Configuration $configuration, array $settings = [])
    {
        $this->configuration = $configuration;
        $this->settings = $settings;
    }

    public function isAvailable(): bool
    {
        $details = $this->getDetails();
        return !empty($details);
    }

    public function getDSN(): string
    {
        return "mysql:host={$this->getHost()};dbname={$this->getDatabase()};"
            . "port={$this->getPort()};charset={$this->getCharset()}";
    }

    public function getCharset(): string
    {
        return $this->getDetails()['charset'] ?? 'utf8';
    }

    public function getHost(): string
    {
        return $this->getDetails()['host'] ?? '';
    }

    public function getPort(): string
    {
        return $this->getDetails()['port'] ?? '3306';
    }

    public function getDatabase(): string
    {
        return $this->getDetails()['dbname'] ?? '';
    }

    public function getUser(): string
    {
        return $this->getDetails()['username'] ?? '';
    }

    public function getPassword(): string
    {
        return $this->getDetails()['password'] ?? '';
    }

    /**
     * @return array<string, array<string, string[]>>
     */
    public function getPreserve(): array
    {
        return $this->settings['preserve'] ?? [];
    }

    /**
     * @return array<string, string>
     */
    private function getDetails(): array
    {
        if (is_array($this->connectionDetails)) {
            return $this->connectionDetails;
        }

        if (!isset($this->settings['path'])) {
            $this->connectionDetails = [];
            return $this->connectionDetails;
        }

        $path = explode('vendor', realpath($_SERVER['SCRIPT_FILENAME']));
        $path = rtrim(reset($path), '/');
        if (!file_exists($path . '/' . $this->settings['path'])) {
            $this->connectionDetails = [];
            return $this->connectionDetails;
        }

        $db = include $path . '/' . $this->settings['path'];

        if (!isset($db['db']['connection']['default'])) {
            $this->connectionDetails = [];
            return $this->connectionDetails;
        }

        $this->connectionDetails = $db['db']['connection']['default'];

        return $this->connectionDetails;
    }
}
