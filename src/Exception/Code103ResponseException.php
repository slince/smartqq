<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Exception;

class Code103ResponseException extends ResponseException
{
    public function __construct($response = null)
    {
        $message = 'Please visit http://w.qq.com, confirm that you can send and receive messages and then exit';
        parent::__construct(103, $response, $message);
    }
}
