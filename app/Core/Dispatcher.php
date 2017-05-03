<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 30.04.17
 * Time: 19:28
 */

namespace Core;


use Core\Dispatcher\RequestEntity;
use Core\Dispatcher\ResponseEntity;

class Dispatcher
{
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function dispatch(RequestEntity $request): ResponseEntity
    {
        $routingMap = [
            '/' => 'Resource\IndexResource',
            '/do/' => 'Resource\DoResource',
            '/admin/' => 'Resource\Admin\IndexResource',
            '/admin/delete/' => 'Resource\Admin\DeleteResource',
            '/admin/groups/' => 'Resource\Admin\GroupsResource',
        ];

        $url = rtrim($request->getCurrentUrl(), '/') . '/';
        if (isset($routingMap[$url])) {
            $method = strtolower($request->getMethod());
            $resource = $routingMap[$url];
        } else {
            $method = 'get';
            $resource = 'Core\Resource\NotFoundResource';
        }
        return (new $resource($this->configuration, $request))->$method();
    }
}