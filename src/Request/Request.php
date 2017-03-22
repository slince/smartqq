<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;

class Request implements RequestInterface
{
    /**
     * 请求地址
     * @var string
     */
    protected $uri;

    /**
     * 请求方式
     * @var string
     */
    protected $method = RequestInterface::REQUEST_METHOD_GET;

    /**
     * referer
     * @var string
     */
    protected $referer;

    /**
     * 请求参数
     * @var array
     */
    protected $parameters = [];

    /**
     * 处理占位符
     * @var array
     */
    protected $tokens = [];

    public function __construct($uri = null, $method = RequestInterface::REQUEST_METHOD_GET, $parameters = [])
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->parameters = $parameters;
    }

    /**
     * 获取请求地址
     * @return string
     */
    public function getUri()
    {
        return $this->processUri($this->uri);
    }

    /**
     * 获取referer
     * @return string
     */
    public function getReferer()
    {
        return $this->processUri($this->referer);
    }

    /**
     * 设置url
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * 设置referer
     * @param string $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }

    /**
     * 获取请求方式
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 获取请求参数
     * @return string
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * 设置参数
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * 设置请求参数
     * @param $name
     * @param $parameter
     */
    public function setParameter($name, $parameter)
    {
        $this->parameters[$name] = $parameter;
    }

    /**
     * 设置链接中的占位符
     * @param array $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * 获取所有的token
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * 设置链接中的指定占位符
     * @param $name
     * @param $token
     */
    public function setToken($name, $token)
    {
        $this->tokens[$name] = $token;
    }

    /**
     * 处理链接中的占位符
     * @param string $uri
     * @return string
     */
    protected function processUri($uri)
    {
        return preg_replace_callback('#\{([a-zA-Z0-9_,]*)\}#i', function ($matches) {
            return isset($this->tokens[$matches[1]]) ? $this->tokens[$matches[1]] : '';
        }, $uri);
    }
}
