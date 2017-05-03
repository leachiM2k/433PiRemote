<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 15:31
 */

namespace Core\Resource;

use Core\Dispatcher\ResponseEntity;

class NotFoundResource extends AbstractResource
{
    public function get(): ResponseEntity
    {
        $response = new ResponseEntity();
        $response->setHttpCode(404)
            ->setHttpMessage('Resource Not Found')
            ->setTemplate('not_found');
        return $response;
    }
}