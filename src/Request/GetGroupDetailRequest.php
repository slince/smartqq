<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetGroupDetailRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_GROUP_DETAIL;

    protected $referer = UrlStore::GET_GROUP_DETAIL_referer;

    function __construct($groupCode)
    {
        $this->url = str_replace('{group_code}', $groupCode, $this->url);
    }
}
