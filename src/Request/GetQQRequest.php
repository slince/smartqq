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

    /**
     * 设置uin和vfwebqq参数
     * @param $uin
     * @param $vfWebQQ
     */
    function setUinAndvfWebQQ($uin, $vfWebQQ)
    {
        $this->url = str_replace(['{uin}', '{vfWebQQ}'], [$uin, $vfWebQQ], $this->url);
    }
}