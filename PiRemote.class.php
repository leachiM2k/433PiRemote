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

	public function addEntry($name, $system, $unit, $inverseAction)
	{
		$data = $this->getEntries();

		if (!isset($name, $system, $unit) || empty($name) || empty($system) || empty($unit))
		{
			return false;
		}

		$newEntry = $this->generateEntry(null, $name, $system, $unit, $inverseAction);

		$data[] = $newEntry;

		return $this->writeEntries($data);
	}

	public function updateEntry($id, $name, $system, $unit, $inverseAction)
	{
		$data = $this->getEntries();

		if (!isset($id, $name, $system, $unit) || empty($id) || empty($name) || empty($system) || empty($unit))
		{
			return false;
		}

		$newEntry = $this->generateEntry($id, $name, $system, $unit, $inverseAction);

		foreach ($data as $key => $entry)
		{
			if ($entry['id'] == $id)
			{
				$data[$key] = $newEntry;
			}
		}

		return $this->writeEntries($data);
	}

	public function deleteEntry($id)
	{
		$data = $this->getEntries();
		$newData = array();

		foreach ($data as $entry)
		{
			if ($entry['id'] == $id)
			{
				continue;
			}
			$newData[] = $entry;
		}

		return $this->writeEntries($newData);
	}

	public function writeEntries($entries)
	{
		return file_put_contents($this->configName, json_encode($entries)) !== false;
	}

	private function generateEntry($id = null, $name, $system, $unit, $inverseAction)
	{
		if (!isset($id))
		{
			$id = uniqid();
		}

		$newEntry = array(
			'id'     => $id,
			'name'   => $name,
			'system' => $system,
			'unit'   => str_pad($unit, 2, "0", STR_PAD_LEFT),
		);

		if (isset($inverseAction))
		{
			$newEntry['inverseAction'] = true;
		}

		return $newEntry;
	}


}
