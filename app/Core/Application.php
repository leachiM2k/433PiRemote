<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 12:49
 */

namespace Core;

use Core\Dispatcher\RequestEntity;

class Application
{
    private $configuration;

    function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function run()
    {
        $request = new RequestEntity($_SERVER);
        $request->setMethod($_SERVER['REQUEST_METHOD'])
            ->setHeader(getallheaders())
            ->setQuery($_GET);

        $dispatcher = new Dispatcher($this->configuration);
        $response = $dispatcher->dispatch($request);

        $redirect = $response->getRedirect();
        if (isset($redirect)) {
            header('Location: ' . $redirect);
        }
        if ($response->getHttpCode() !== 200) {
            header('HTTP/1.0 ' . $response->getHttpCode() . ' ' . $response->getHttpMessage());
        }

        if (in_array('application/json', $this->getAcceptedContentTypes($request))) {
            header('Content-Type: application/json');
            echo json_encode($response->getPayload());
        }

        if (in_array('text/html', $this->getAcceptedContentTypes($request))) {
            echo $this->configuration->getRenderer()->render($response);
        }
    }

    /**
     * @param $request
     * @return array
     */
    protected function getAcceptedContentTypes(RequestEntity $request): array
    {
        $acceptHeader = $request->getHeaderValue('Accept');
        if (isset($acceptHeader)) {
            $acceptedTypes = explode(',', $acceptHeader);
            return array_map(function ($item) {
                return explode(';', $item)[0];
            }, $acceptedTypes);
        }
        return [];
    }


}