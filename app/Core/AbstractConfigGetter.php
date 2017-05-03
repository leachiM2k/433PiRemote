<?php
namespace Core;

abstract class AbstractConfigGetter {
    protected $configName;

    public function __construct()
    {
        $this->configName = __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . $this->getConfigFileName();
    }

    public function isConfigWritable()
    {
        return is_writable($this->configName);
    }

    public function getEntries()
    {
        $data = array();
        if (file_exists($this->configName))
        {
            $data = json_decode(file_get_contents($this->configName), true);
        }
        return $data;
    }

    public function getEntry($id)
    {
        $data = $this->getEntries();
        foreach ($data as $entry)
        {
            if ($entry['id'] == $id)
            {
                return $entry;
            }
        }
        return null;
    }

    protected abstract function getConfigFileName();
} 