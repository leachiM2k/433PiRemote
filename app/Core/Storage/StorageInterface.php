<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 14:15
 */

namespace Core\Storage;

interface StorageInterface
{
    public function getEntries(string $tableName): array;

    public function getEntry(string $tableName, $id): array;

    public function hasWriteRights(string $tableName): bool;

    public function addEntry(string $tableName, $newEntry): bool;

    public function updateEntry(string $tableName, $id, $newEntry): bool;

    public function deleteEntry(string $tableName, $id): bool;
}