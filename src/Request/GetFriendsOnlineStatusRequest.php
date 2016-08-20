<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetFriendsOnlineStatusRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_FRIENDS_ONLINE_STATUS;

    protected $referer = UrlStore::GET_FRIENDS_ONLINE_STATUS_REFERER;
}