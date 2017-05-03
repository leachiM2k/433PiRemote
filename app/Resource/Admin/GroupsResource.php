<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 15:31
 */

namespace Resource\Admin;

use Core\Dispatcher\ResponseEntity;
use Core\PiRemote;
use Core\RemoteGroups;
use Core\Resource\AbstractResource;

class GroupsResource extends AbstractResource
{
    public function get(): ResponseEntity
    {
        $groupsBackend = new RemoteGroups($this->configuration->getStorage());
        $remoteBackend = new PiRemote($this->configuration->getStorage());

        $remotes = [];
        foreach ($remoteBackend->getEntries() as $remote) {
            $remotes[$remote['id']] = $remote;
        }

        $groups = $groupsBackend->getEntries();
        foreach ($groups as $id => $group) {
            $linkedGroupRemotes = array();
            foreach ($group['remotes'] as $groupRemote) {
                $linkedGroupRemotes[$groupRemote] = $remotes[$groupRemote];
            }
            $groups[$id]['remotes'] = $linkedGroupRemotes;
        }

        $payload = [
            'groups' => $groups,
            'remotes' => $remotes,
            'isConfigWritable' => $groupsBackend->hasWriteRights(),
            'baseUrl' => $this->request->getBaseUrl(),
        ];

        $response = new ResponseEntity();
        $response->setTemplate('admin/groups')
            ->setPayload($payload);
        return $response;
    }

    public function post(): ResponseEntity
    {
        $redirectUrl = '/admin/groups';
        $groupsBackend = new RemoteGroups($this->configuration->getStorage());
        $action = $this->request->getBodyValue('action');

        if (isset($action)) {
            $body = $this->request->getBody();
            if ($action == 'update') {
                $result = $groupsBackend->updateEntry($body['id'], $body['name'], $body['remote'], $body['delay']);
                $redirectUrl .= '?success=' . $result;
            } else if ($action == 'add') {
                $result = $groupsBackend->addEntry($body['name'], $body['remote'], $body['delay']);
                $redirectUrl .= '?success=' . $result;
            }
        }

        $response = new ResponseEntity();
        $response->setRedirect($redirectUrl);
        return $response;

    }
}