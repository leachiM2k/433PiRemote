<?php
error_log(E_ALL);
ini_set("display_errors", "on");

$includeBaseDir = realpath("../") . '/';
include_once $includeBaseDir . 'vendor/autoload.php';
include_once $includeBaseDir . 'PiRemote.class.php';
include_once $includeBaseDir . 'RemoteGroups.class.php';

$twigTemplates = new Twig_Loader_Filesystem($includeBaseDir . 'twig/templates');
$twig = new Twig_Environment($twigTemplates, array(
    'cache' => $includeBaseDir . 'twig/cache',
    'debug' => true,
));

$groupsBackend = new RemoteGroups();

if(!empty($_POST) && isset($_POST['action']))
{
    $action = $_POST['action'];

    if($action == "update") {
        $groupsBackend->updateEntry($_POST['id'], $_POST['name'], $_POST['remote'], $_POST['delay']);
    }
    if($action == "add") {
        $groupsBackend->addEntry($_POST['name'], $_POST['remote'], $_POST['delay']);
    }
    header("Location: groups.php");
}

$groups = $groupsBackend->getEntries();

$remoteBackend = new PiRemote();
$remotes = array();
foreach ($remoteBackend->getEntries() as $remote) {
    $remotes[$remote['id']] = $remote;
}

foreach ($groups as $id => $group) {
    $linkedGroupRemotes = array();
    foreach ($group['remotes'] as $groupRemote) {
        $linkedGroupRemotes[$groupRemote] = $remotes[$groupRemote];
    }
    $groups[$id]['remotes'] = $linkedGroupRemotes;
}

$twigParams  = array(
    'groups' => $groups,
    'remotes' => $remotes,
    'isConfigWritable' => $groupsBackend->isConfigWritable(),
);
echo $twig->render("admin/groups.html.twig", $twigParams);
