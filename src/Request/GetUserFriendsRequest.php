<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetUserFriendsRequest extends AbstractRequest
{

    protected $url = UrlStore::GET_USER_FRIENDS;

    protected $referer = UrlStore::GET_USER_FRIENDS_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;
}
