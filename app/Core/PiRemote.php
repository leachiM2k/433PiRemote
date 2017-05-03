<?php

namespace Core;

use Core\Storage\StorageInterface;

class PiRemote
{
    const TABLENAME = 'config';

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getEntries()
    {
        return $this->storage->getEntries(self::TABLENAME);
    }

    public function getEntry($id)
    {
        return $this->storage->getEntry(self::TABLENAME, $id);
    }

    public function hasWriteRights()
    {
        return $this->storage->hasWriteRights(self::TABLENAME);
    }

    public function addEntry($name, $system, $unit, $inverseAction)
    {
        if (!isset($name, $system, $unit) || empty($name) || empty($system) || empty($unit)) {
            return false;
        }

        $newEntry = $this->generateEntry(null, $name, $system, $unit, $inverseAction);

        return $this->storage->addEntry(self::TABLENAME, $newEntry);
    }

    public function updateEntry($id, $name, $system, $unit, $inverseAction)
    {
        if (!isset($id, $name, $system, $unit) || empty($id) || empty($name) || empty($system) || empty($unit)) {
            return false;
        }

        $newEntry = $this->generateEntry($id, $name, $system, $unit, $inverseAction);

        return $this->storage->updateEntry(self::TABLENAME, $id, $newEntry);
    }

    public function deleteEntry($id)
    {
        return $this->storage->deleteEntry(self::TABLENAME, $id);
    }

    private function generateEntry($id = null, $name, $system, $unit, $inverseAction)
    {
        if (!isset($id)) {
            $id = uniqid();
        }

        $newEntry = array(
            'id' => $id,
            'name' => $name,
            'system' => $system,
            'unit' => str_pad($unit, 2, "0", STR_PAD_LEFT),
        );

        if (isset($inverseAction)) {
            $newEntry['inverseAction'] = true;
        }

        return $newEntry;
    }

}
