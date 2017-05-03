<?php
namespace Core;

use Core\Storage\StorageInterface;

class RemoteGroups
{
    const TABLENAME = 'groups';

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

    public function addEntry($name, $remote, $delay): bool
    {
        // TODO
        return false;
    }

    public function updateEntry($id, $name, $remote, $delay): bool
    {
        // TODO
        return false;
    }
}