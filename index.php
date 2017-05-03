<?php
include_once 'vendor/autoload.php';
include_once 'PiRemote.class.php';
include_once 'RemoteGroups.class.php';
$remoteBackend = new PiRemote();

$twigTemplates = new Twig_Loader_Filesystem('twig/templates');
$twig = new Twig_Environment($twigTemplates, array(
    'cache' => 'twig/cache',
#    'debug' => true,
));

$data = $remoteBackend->getEntries();
$groupsBackend = new RemoteGroups();
$groups = $groupsBackend->getEntries();


$twigParams = array(
    'data' => $data,
    'groups' => $groups,
    'baseUrl' => rtrim(pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME), '/'),
);

echo $twig->render("index.html.twig", $twigParams);
