<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetDiscusDetailRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_DISCUS_DETAIL;

    protected $referer = UrlStore::GET_DISCUS_DETAIL_REFERER;

    function __construct($discussId)
    {
        $this->url = str_replace('{discuss_id}', $discussId, $this->url);
    }
}