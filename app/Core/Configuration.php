<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 13:00
 */

namespace Core;


class Configuration
{
    private $generalConfig = [];
    private $renderer;
    private $storage;

    /**
     * @return array
     */
    public function getGeneralConfig(): array
    {
        return $this->generalConfig;
    }

    /**
     * @param array $generalConfig
     * @return Configuration
     */
    public function setGeneralConfig(array $generalConfig): Configuration
    {
        $this->generalConfig = $generalConfig;
        return $this;
    }

    /**
     * @param mixed $renderer
     * @return Configuration
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @param mixed $storage
     * @return Configuration
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }
}