<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetFriendDetailRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_FRIEND_DETAIL;

    protected $referer = UrlStore::GET_FRIEND_DETAIL_REFERER;

    function __construct($uin)
    {
        return str_replace('{uin}', $uin, $this->url);
    }
}
