<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 30.04.17
 * Time: 19:28
 */

namespace Core\Dispatcher;


class ResponseEntity
{
    private $httpCode = 200;
    private $httpMessage = 'OK';
    private $redirect;
    private $template;
    private $payload = [];

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     * @return ResponseEntity
     */
    public function setHttpCode(int $httpCode): ResponseEntity
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getHttpMessage(): string
    {
        return $this->httpMessage;
    }

    /**
     * @param string $httpMessage
     * @return ResponseEntity
     */
    public function setHttpMessage(string $httpMessage): ResponseEntity
    {
        $this->httpMessage = $httpMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param string $redirect
     * @return ResponseEntity
     */
    public function setRedirect(string $redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     * @return ResponseEntity
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @return ResponseEntity
     */
    public function setPayload(array $payload): ResponseEntity
    {
        $this->payload = $payload;
        return $this;
    }
}