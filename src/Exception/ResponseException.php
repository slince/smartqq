<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
        $message = $message ?: 'The response is incorrect';
        parent::__construct($message, $code);
    }

    /**
     * @param null $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
