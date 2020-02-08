<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc. 2/8/20
 * @website https://swiftotter.com
 **/

namespace Driver\Magento2;

use Driver\Engines\ConnectionInterface;
use Driver\Engines\ConnectionTrait;
use Driver\System\Configuration;

class Magento2Connection implements ConnectionInterface
{
    use ConnectionTrait;

    /** @var Configuration */
    private $configuration;

    /** @var array */
    private $connectionDetails;

    /** @var array */
    private $settings;

    public function __construct(Configuration $configuration, array $settings = [])
    {
        $this->configuration = $configuration;
        $this->settings = $settings;
    }

    private function getDetails()
    {
        if ($this->connectionDetails === false || is_array($this->connectionDetails)) {
            return $this->connectionDetails;
        }

        if (!is_array($this->settings) || !isset($this->settings['path'])) {
            $this->connectionDetails = false;
            return $this->connectionDetails;
        }

        $path = explode('vendor', __DIR__);
        $path = rtrim(reset($path), '/');
        if (!file_exists($path . '/' . $this->settings['path'])) {
            $this->connectionDetails = false;
            return $this->connectionDetails;
        }

        $db = include $path . '/' . $this->settings['path'];

        if (!isset($db['db']['connection']['default'])) {
            $this->connectionDetails = false;
            return $this->connectionDetails;
        }

        $this->connectionDetails = $db['db']['connection']['default'];

        return $this->connectionDetails;
    }

    public function isAvailable(): bool
    {
        $details = $this->getDetails();

        return is_array($details);
    }

    public function getDSN(): string
    {
        return "mysql:host={$this->getHost()};dbname={$this->getDatabase()};port={$this->getPort()};charset={$this->getCharset()}";
    }

    public function getCharset(): string
    {
        return $this->getDetails()['charset'] ?? 'utf8';
    }

    public function getHost(): string
    {
        return $this->getDetails()['host'];
    }

    public function getPort(): string
    {
        return $this->getDetails()['port'] ?? '3306';
    }

    public function getDatabase(): string
    {
        return $this->getDetails()['dbname'];
    }

    public function getUser(): string
    {
        return $this->getDetails()['username'];
    }

    public function getPassword(): string
    {
        return $this->getDetails()['password'];
    }
}