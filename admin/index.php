<?php
error_log(E_ALL);
ini_set("display_errors", "on");

$includeBaseDir = realpath("../") . '/';
include_once $includeBaseDir . 'vendor/autoload.php';
include_once $includeBaseDir . 'PiRemote.class.php';

$twigTemplates = new Twig_Loader_Filesystem($includeBaseDir . 'twig/templates');
$twig = new Twig_Environment($twigTemplates, array(
    'cache' => $includeBaseDir . 'twig/cache',
#    'debug' => true,
));

$remoteBackend = new PiRemote();

if(!empty($_POST) && isset($_POST['action']))
{
	$action = $_POST['action'];

	if($action == "update") {
		$remoteBackend->updateEntry($_POST['id'], $_POST['name'], $_POST['system'], $_POST['unit'], $_POST['inverseAction']);
	}
	if($action == "add") {
		$remoteBackend->addEntry($_POST['name'], $_POST['system'], $_POST['unit'], $_POST['inverseAction']);
	}
	header("Location: index.php");
}

$data = $remoteBackend->getEntries();

$twigParams  = array(
    'data' => $data,
    'isConfigWritable' => $remoteBackend->isConfigWritable(),
    'baseUrl' => pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME),
);
echo $twig->render("admin/index.html.twig", $twigParams);
