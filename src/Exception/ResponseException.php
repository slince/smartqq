<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Exception;

class ResponseException extends RuntimeException
{
    protected $response;

    public function __construct($code, $response = null, $message = null)
    {
        if (!is_null($response)) {
            $this->response = $response;
        }
        $message = $message ?: "The response is incorrect";
        parent::__construct($message, $code);
    }

    /**
     * @param null $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
