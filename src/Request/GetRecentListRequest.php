<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetRecentListRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_RECENT_LIST;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;
}
