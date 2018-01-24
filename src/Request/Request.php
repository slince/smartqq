<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Request;

class Request implements RequestInterface
{
    /**
     * 请求地址
     *
     * @var string
     */
    protected $uri;

    /**
     * referer.
     *
     * @var string
     */
    protected $referer;

    /**
     * 请求方式.
     *
     * @var string
     */
    protected $method = RequestInterface::REQUEST_METHOD_GET;

    /**
     * 请求参数.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * 处理占位符.
     *
     * @var array
     */
    protected $tokens = [];

    /**
     * 获取请求地址
     *
     * @return string
     */
    public function getUri()
    {
        return $this->processUri($this->uri);
    }

    /**
     * 获取referer.
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->processUri($this->referer);
    }

    /**
     * 设置uri.
     *
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * 设置referer.
     *
     * @param string $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }

    /**
     * 获取请求方式.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 获取请求参数.
     *
     * @return string
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * 设置参数.
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * 设置请求参数.
     *
     * @param string $name
     * @param string $parameter
     */
    public function setParameter($name, $parameter)
    {
        $this->parameters[$name] = $parameter;
    }

    /**
     * 设置链接中的占位符.
     *
     * @param array $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * 获取所有的token.
     *
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * 设置链接中的指定占位符.
     *
     * @param string $name
     * @param string $token
     */
    public function setToken($name, $token)
    {
        $this->tokens[$name] = $token;
    }

    /**
     * 处理链接中的占位符.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function processUri($uri)
    {
        return preg_replace_callback('#\{([a-zA-Z0-9_,]*)\}#i', function($matches) {
            return isset($this->tokens[$matches[1]]) ? $this->tokens[$matches[1]] : '';
        }, $uri);
    }
}
