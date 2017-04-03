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
        parent::__construct(103, $response, "Please Login Smartqq And Logout");
    }
}
