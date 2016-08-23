<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetUinAndPsessionidRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_UINANDPSESSIONID;

    protected $referer = UrlStore::GET_UINANDPSESSIONID_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;
}
