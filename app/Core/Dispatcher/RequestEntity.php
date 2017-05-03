<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 30.04.17
 * Time: 19:28
 */

namespace Core\Dispatcher;


class RequestEntity
{
    private $meta = [];
    private $method;
    private $header = [];
    private $query = [];

    public function __construct(array $meta)
    {
        $this->meta = $meta;
    }

    public function getCurrentUrl()
    {
        return isset($this->meta['REQUEST_URI']) ? strtok($this->meta['REQUEST_URI'], '?') : '';
    }

    public function getBaseUrl()
    {
        $scriptName = isset($this->meta['SCRIPT_NAME']) ? $this->meta['SCRIPT_NAME'] : '';
        return rtrim(pathinfo($scriptName, PATHINFO_DIRNAME), '/');
    }

    public function isAjaxRequest(): bool
    {
        $xRequestedWith = isset($this->meta['HTTP_X_REQUESTED_WITH']) ? $this->meta['HTTP_X_REQUESTED_WITH'] : null;
        return $xRequestedWith === 'XMLHttpRequest';
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return RequestEntity
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param string $specificKey
     * @return string
     */
    public function getHeaderValue(string $specificKey): ?string
    {
        return isset($this->header[$specificKey]) ? $this->header[$specificKey] : null;
    }

    /**
     * @param array $header
     * @return RequestEntity
     */
    public function setHeader(array $header): RequestEntity
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        if (isset($specificKey)) {
            return isset($this->query[$specificKey]) ? $this->query[$specificKey] : null;
        }
        return $this->query;
    }

    /**
     * @param string $specificKey
     * @return string
     */
    public function getQueryValue(string $specificKey): ?string
    {
        return isset($this->query[$specificKey]) ? $this->query[$specificKey] : null;
    }

    /**
     * @param array $query
     * @return RequestEntity
     */
    public function setQuery(array $query): RequestEntity
    {
        $this->query = $query;
        return $this;
    }
}