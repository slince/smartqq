<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetFriendDetailRequest
{
    protected $url = UrlStore::GET_FRIEND_DETAIL;

    protected $referer = UrlStore::GET_FRIEND_DETAIL_REFERER;

    /**
     * 设置uin、vfwebqq、psessionid参数
     * @param $uin
     * @param $vfWebQQ
     * @param $psessionid
     */
    function setUinAndvfWebQQAndPsessionid($uin, $vfWebQQ, $psessionid)
    {
        $this->url = str_replace(['{uin}', '{vfWebQQ}', '{psessionid}'], [$uin, $vfWebQQ, $psessionid], $this->url);
    }
}