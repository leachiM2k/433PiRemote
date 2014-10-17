<?php
require_once "AbstractConfigGetter.class.php";

class RemoteGroups extends AbstractConfigGetter
{
    protected function getConfigFileName()
    {
        return "groups.json";
    }

    public function addEntry($name, $remote, $delay)
    {
        // TODO
    }

    public function updateEntry($id, $name, $remote, $delay)
    {
        // TODO
    }
}