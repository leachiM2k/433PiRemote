<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 13:39
 */

namespace Core\Storage;


class StorageFactory
{
    private $config;

    public function __construct($storageConfig)
    {
        $this->config = $storageConfig;
    }

    public function getStorage(): StorageInterface
    {
        $name = strtolower($this->config['storage']);

        switch ($name) {
            case 'file':
                return new FileStorage($this->config);
                break;
        }
        throw new \RuntimeException('Can not instantiate unknown storage type ' . $name);

    }
}