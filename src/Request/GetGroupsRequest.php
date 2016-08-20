<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetGroupsRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_GROUPS;

    protected $referer = UrlStore::GET_GROUPS_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;
}