<?php
include_once 'PiRemote.class.php';
$remoteBackend = new PiRemote();

$id = $_GET['id'];
if(isset($id) && is_numeric($id))
{
	$remoteBackend->deleteEntry($id);
}

header("Location: index.php");
