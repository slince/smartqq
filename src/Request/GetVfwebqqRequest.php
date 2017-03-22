<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetVfwebqqRequest extends Request
{
    protected $url = UrlStore::GET_VFWEBQQ;

    protected $referer = UrlStore::GET_VFWEBQQ_REFERER;
}
