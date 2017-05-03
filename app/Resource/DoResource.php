<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 15:31
 */

namespace Resource;

use Core\Dispatcher\ResponseEntity;
use Core\PiRemote;
use Core\RemoteGroups;
use Core\Resource\AbstractResource;

class DoResource extends AbstractResource
{
    public function get(): ResponseEntity
    {
        $remoteBackend = new PiRemote($this->configuration->getStorage());
        $groupsBackend = new RemoteGroups($this->configuration->getStorage());

        $payload = [];

        $getAction = $this->request->getQueryValue('action');
        $getId = $this->request->getQueryValue('id');
        $getGroup = $this->request->getQueryValue('group');

        $payload['triggeredRemotes'] = $this->processGroups($remoteBackend, $groupsBackend, $getGroup, $getAction);
        $this->processSingleRemote($remoteBackend, $getId, $getAction);

        $response = new ResponseEntity();
        if ($this->request->isAjaxRequest()) {
            $response->setTemplate('general');
            $response->setPayload(['result' => 'success']);
        } else {
            $response->setRedirect('/');
        }

        return $response;
    }

    /**
     * @param PiRemote $remoteBackend
     * @param RemoteGroups $groupsBackend
     * @param $groupId
     * @param $action
     * @return int|null
     */
    protected function processGroups(PiRemote $remoteBackend, RemoteGroups $groupsBackend, $groupId, $action)
    {
        if (!isset($groupId, $action)) {
            return null;
        }

        $entry = $groupsBackend->getEntry($groupId);
        if (isset($entry)) {
            $triggeredRemotes = 0;

            foreach ($remoteBackend->getEntries() as $remote) {
                if (in_array($remote['id'], $entry['remotes'])) {
                    $nAction = null;
                    if ($action == "on") {
                        $nAction = (!$remote['inverseAction'] ? 1 : 0);
                    }
                    if ($action == "off") {
                        $nAction = (!$remote['inverseAction'] ? 0 : 1);
                    }
                    $delay = 0;
                    $this->performAction($remote['system'], $remote['unit'], $nAction, $delay);
                    $triggeredRemotes++;
                    usleep($entry['delay'] * 1000000);
                }
            }

            return $triggeredRemotes;
        }
        return null;
    }

    /**
     * @param PiRemote $remoteBackend
     * @param $remoteId
     * @param $action
     * @return void
     */
    protected function processSingleRemote(PiRemote $remoteBackend, $remoteId, $action): void
    {
        if (!isset($remoteId, $action)) {
            return;
        }

        $entry = $remoteBackend->getEntry($remoteId);
        if (isset($entry)) {
            $nAction = null;
            if ($action == "on") {
                $nAction = (!$entry['inverseAction'] ? 1 : 0);
            }
            if ($action == "off") {
                $nAction = (!$entry['inverseAction'] ? 0 : 1);
            }
            $delay = 0;
            $this->performAction($entry['system'], $entry['unit'], $nAction, $delay);
        }
    }

    private function performAction($systemcode, $unitcode, $action, $delay)
    {
        $source = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : null;
        $target = $this->configuration->getGeneralConfig()['remoteServer']['host'];
        $port = $this->configuration->getGeneralConfig()['remoteServer']['port'];

        $output = $systemcode . $unitcode . $action . $delay;
        if (strlen($output) < 8) {
            return;
        }
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
        if ($source) {
            socket_bind($socket, $source) or die("Could not bind to socket\n");
        }
        socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
        socket_write($socket, $output, strlen($output)) or die("Could not write output\n");
        socket_close($socket);
    }
}