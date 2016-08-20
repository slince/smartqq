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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    function getRequestMethod()
    {
        return static::REQUEST_METHOD_GET;
    }
}