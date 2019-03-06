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

class IndexResource extends AbstractResource
{
    public function get(): ResponseEntity
    {
        $remoteBackend = new PiRemote($this->configuration->getStorage());
        $groupsBackend = new RemoteGroups($this->configuration->getStorage());

        $payload = [
            'data' => $remoteBackend->getEntries(),
            'groups' => $groupsBackend->getEntries(),
            'baseUrl' => $this->request->getBaseUrl(),
        ];

        $response = new ResponseEntity();
        $response->setTemplate('spa')
            ->setPayload($payload);
        return $response;
    }
}
