<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

interface RequestInterface
{
    /**
     * 请求方式，Get
     * @var string
     */
    const REQUEST_METHOD_GET = 'get';

    /**
     * 请求方式，Post
     * @var string
     */
    const REQUEST_METHOD_POST = 'post';

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

    /**
     * 获取请求参数
     * @return string
     */
    function getParameters();

    /**
     * 设置请求参数
     * @param array $parameters
     */
    function setParameters(array $parameters);

    /**
     * 设置请求参数
     * @param $name
     * @param $parameter
     */
    function setParameter($name, $parameter);

    /**
     * 设置链接中的占位符
     * @param $tokens
     */
    function setTokens($tokens);

    /**
     * 设置链接中的指定占位符
     * @param $name
     * @param $token
     */
    function setToken($name, $token);
}