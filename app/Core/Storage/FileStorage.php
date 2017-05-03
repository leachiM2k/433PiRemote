<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 13:43
 */

namespace Core\Storage;


class FileStorage implements StorageInterface
{
    private $path;

    public function __construct($config)
    {
        ['path' => $this->path] = $config;
    }

    private function getConfigFileName($tableName)
    {
        return realpath($this->path . DIRECTORY_SEPARATOR . $tableName . '.json');
    }

    public function getEntries(string $tableName): array
    {
        $filename = $this->getConfigFileName($tableName);
        $data = array();
        if (file_exists($filename)) {
            $data = json_decode(file_get_contents($filename), true);
        }
        return $data;
    }

    public function getEntry(string $tableName, $id): array
    {
        $data = $this->getEntries($tableName);
        foreach ($data as $entry) {
            if ($entry['id'] == $id) {
                return $entry;
            }
        }
        return null;
    }

    public function addEntry(string $tableName, $newEntry): bool
    {
        $entries = $this->getEntries($tableName);
        if (!isset($entries) || !is_array($entries)) {
            $entries = [];
        }
        $entries[] = $newEntry;
        return $this->writeEntries($tableName, $entries);
    }

    public function updateEntry(string $tableName, $id, $newEntry): bool
    {
        $entries = $this->getEntries($tableName);
        if (!isset($entries) || !is_array($entries)) {
            $entries = [];
        }

        foreach ($entries as $key => $entry) {
            if ($entry['id'] == $id) {
                $entries[$key] = $newEntry;
            }
        }
        return $this->writeEntries($tableName, $entries);
    }

    public function deleteEntry(string $tableName, $id): bool
    {
        $entries = $this->getEntries($tableName);
        if (!isset($entries) || !is_array($entries)) {
            $entries = [];
        }
        $newData = array_filter($entries, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        return $this->writeEntries($tableName, $newData);
    }

    /**
     * @param string $tableName
     * @param array $entries
     * @return bool
     */
    protected function writeEntries(string $tableName, array $entries): bool
    {
        $filename = $this->getConfigFileName($tableName);
        return file_put_contents($filename, json_encode($entries)) !== false;
    }
}