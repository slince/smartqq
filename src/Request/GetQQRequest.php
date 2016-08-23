<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetQQRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_QQ;

    protected $referer = UrlStore::GET_QQ_REFERER;

    function __construct($uin)
    {
        return str_replace('{uin}', $uin, $this->url);
    }
}
