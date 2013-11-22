<?php

class PiRemote
{
	public function __construct()
	{
		$this->configName = __DIR__ . DIRECTORY_SEPARATOR . "data/config.json";
	}

	public function isConfigWritable()
	{
		return is_writable($this->configName);
	}

	public function getEntries()
	{
		$data = array();
		if(file_exists($this->configName))
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
			if($entry['id'] == $id)
			{
				return $entry;
			}
		}
		return null;
	}

	public function deleteEntry($id)
	{
		$data = $this->getEntries();
		$newData = array();

		foreach ($data as $entry)
		{
			if($entry['id'] == $id)
			{
				continue;
			}
			$newData[] = $entry;
		}

		$this->writeEntries($newData);
	}

	public function writeEntries($entries)
	{
		file_put_contents($this->configName, json_encode($entries));
	}
}
