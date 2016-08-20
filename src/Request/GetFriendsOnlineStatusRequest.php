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

    /**
     * 设置vfwebqq和psessionid参数
     * @param $vfWebQQ
     */
    function setVfWebQQAndPsessionid($vfWebQQ, $psessionid)
    {
        $this->url = str_replace(['{vfWebQQ}', '{psessionid}'], [$vfWebQQ, $psessionid], $this->url);
    }
}