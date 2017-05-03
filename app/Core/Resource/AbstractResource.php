<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 03.05.17
 * Time: 07:11
 */

namespace Core\Resource;

use Core\Configuration;
use Core\Dispatcher\RequestEntity;

abstract class AbstractResource
{
    protected $configuration;
    protected $request;

    public function __construct(Configuration $configuration, RequestEntity $request)
    {
        $this->configuration = $configuration;
        $this->request = $request;
    }

}