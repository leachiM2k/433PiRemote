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
use Core\Resource\AbstractResource;

class IndexResource extends AbstractResource
{
    public function get(): ResponseEntity
    {
        $remoteBackend = new PiRemote($this->configuration->getStorage());

        $payload = [
            'data' => $remoteBackend->getEntries(),
            'isConfigWritable' => $remoteBackend->hasWriteRights(),
            'baseUrl' => $this->request->getBaseUrl(),
        ];

        $response = new ResponseEntity();
        $response->setTemplate('admin/index')
            ->setPayload($payload);
        return $response;
    }

    public function post(): ResponseEntity
    {
        $redirectUrl = '/admin/';
        $remoteBackend = new PiRemote($this->configuration->getStorage());
        $action = $this->request->getBodyValue('action');

        if (isset($action)) {
            $body = $this->request->getBody();
            if ($action == 'update') {
                $result = $remoteBackend->updateEntry($body['id'], $body['name'], $body['system'], $body['unit'], $body['inverseAction']);
                $redirectUrl .= '?success=' . $result;
            } else if ($action == 'add') {
                $result = $remoteBackend->addEntry($body['name'], $body['system'], $body['unit'], $body['inverseAction']);
                $redirectUrl .= '?success=' . $result;
            }
        }

        $response = new ResponseEntity();
        $response->setRedirect($redirectUrl);
        return $response;

    }
}