<?php
include_once '../PiRemote.class.php';
include_once '../RemoteGroups.class.php';
$remoteBackend = new PiRemote();

include_once '../config.php';

if($_SERVER['HTTP_X_API_TOKEN'] !== $apiToken)
{
    header('HTTP/1.0 401 Unauthorized');
    return;
}

function performAction($group, $switch, $action, $delay)
{
    include_once '../config.php';
    $output = $group . $switch . $action . $delay;
    if (strlen($output) < 8)
        return;
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
    socket_bind($socket, $source) or die("Could not bind to socket\n");
    socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
    socket_write($socket, $output, strlen($output)) or die("Could not write output\n");
    socket_close($socket);
}

function performPilightCall($entry, $state) {
    require '../config.php';
    $output = array();
    $output['code'] = $entry['code'];
    $output['action'] = 'send';
    $output['code'][$state] = 1;
    $output = json_encode($output);
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
    socket_bind($socket, $source) or die("Could not bind to socket\n");
    socket_connect($socket, $pilightHost, $pilightPort) or die("Could not connect to socket\n");
    socket_write($socket, $output, strlen($output)) or die("Could not write output\n");
    socket_close($socket);
}

/*
 * actually send to the daemon
 * then reload the webpage without parameters
 */
$getId = (isset($_GET['id']) ? $_GET['id'] : null);
$getAction = (isset($_GET['action']) ? $_GET['action'] : null);
if (isset($getId, $getAction))
{
    $entry = $remoteBackend->getEntry($getId);
    if (isset($entry)) {
        if ($entry['pilight']) {
            performPilightCall($entry, $getAction);
        } else {
            $nGroup = $entry['system'];
            $nSwitch = $entry['unit'];
            if ($getAction == "on")
                $nAction = (!$entry['inverseAction'] ? 1 : 0);
            if ($getAction == "off")
                $nAction = (!$entry['inverseAction'] ? 0 : 1);
            $nDelay = 0;
            performAction($nGroup, $nSwitch, $nAction, $nDelay);
        }
        header('Content-Type: application/json');
        echo json_encode(['ok' => true]);
        return;
    }
}

if (isset($nAll))
{
    $data = $remoteBackend->getEntries();
    foreach ($data as $current)
    {
        $ig = $current["system"];
        $is = $current["unit"];
        $ii = $current["inverseAction"];
        if ($ii)
            $nAll = abs($nAll - 1);
        performAction($ig, $is, $nAll, $nDelay);
        time_nanosleep(0, 500000000);
    }
    header('Content-Type: application/json');
    echo json_encode(['ok' => true]);
    return;
}
