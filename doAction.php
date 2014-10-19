<?php
require_once 'PiRemote.class.php';
$remoteBackend = new PiRemote();

function performAction($systemcode, $unitcode, $action, $delay)
{
    include_once 'config.php';
    $output = $systemcode . $unitcode . $action . $delay;
    if (strlen($output) < 8)
        return;
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
    socket_bind($socket, $source) or die("Could not bind to socket\n");
    socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
    socket_write($socket, $output, strlen($output)) or die("Could not write output\n");
    socket_close($socket);
}

/*
 * actually send to the daemon
 */
$getAction = (isset($_GET['action']) ? $_GET['action'] : null);
$getId = (isset($_GET['id']) ? $_GET['id'] : null);
$getGroup = (isset($_GET['group']) ? $_GET['group'] : null);
if (isset($getGroup, $getAction)) {

    require_once 'RemoteGroups.class.php';
    $groupBackend = new RemoteGroups();
    $entry = $groupBackend->getEntry($getGroup);
    if (isset($entry)) {
        $triggeredRemotes = 0;

        foreach ($remoteBackend->getEntries() as $remote) {
            if (in_array($remote['id'], $entry['remotes'])) {
                if ($getAction == "on")
                    $nAction = (!$remote['inverseAction'] ? 1 : 0);
                if ($getAction == "off")
                    $nAction = (!$remote['inverseAction'] ? 0 : 1);
                $delay = 0;
                performAction($remote['system'], $remote['unit'], $nAction, $delay);
                $triggeredRemotes++;
                usleep($entry['delay'] * 1000);
            }
        }

        echo json_encode(array('result' => 'success', 'triggered' => $triggeredRemotes));
    } else {
        echo json_encode(array('result' => 'no entry found'));
    }

} elseif (isset($getId, $getAction)) {

    $entry = $remoteBackend->getEntry($getId);
    if (isset($entry)) {
        if ($getAction == "on")
            $nAction = (!$entry['inverseAction'] ? 1 : 0);
        if ($getAction == "off")
            $nAction = (!$entry['inverseAction'] ? 0 : 1);
        $delay = 0;
        performAction($entry['system'], $entry['unit'], $nAction, $delay);
        echo json_encode(array('result' => 'success'));
    } else {
        echo json_encode(array('result' => 'no entry found'));
    }

} else {
    echo json_encode(array('result' => 'param fail'));
}
