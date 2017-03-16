<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Exception;

class Code103ResponseException extends RuntimeException
{
    function __construct()
    {
        parent::__construct("Please Login Smartqq And Logout", 103);
    }
}