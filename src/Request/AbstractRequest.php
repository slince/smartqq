<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

class AbstractRequest implements RequestInterface
{
    /**
     * 请求地址
     * @var string
     */
    protected $url;

    /**
     * referer
     * @var string
     */
    protected $referer;

    /**
     * 请求方式
     * @var string
     */
    protected $requestMethod = RequestInterface::REQUEST_METHOD_GET;

    /**
     * 请求参数
     * @var array
     */
    protected $parameters = [];

    /**
     * 获取请求地址
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 获取referer
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
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
    function getRequestMethod()
    {
        return $this->requestMethod;
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
}