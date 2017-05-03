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

class DeleteResource extends AbstractResource
{
    public function get(): ResponseEntity
    {
        $redirectUrl = '/admin/';
        $remoteBackend = new PiRemote($this->configuration->getStorage());

        $id = $this->request->getQueryValue('id');
        if (isset($id)) {
            $result = $remoteBackend->deleteEntry($id);
            $redirectUrl .= '?success=' . $result;
        }

        $response = new ResponseEntity();
        $response->setRedirect($redirectUrl);
        return $response;
    }
}