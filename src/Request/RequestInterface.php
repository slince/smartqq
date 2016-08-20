<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

interface RequestInterface
{
    const REQUEST_METHOD_GET = 'get';

    /**
     * 获取请求地址
     * @return string
     */
    function getUrl();

    /**
     * 获取referer
     * @return string
     */
    function getReferer();

    /**
     * 获取请求方式
     * @return string
     */
    function getRequestMethod();
}