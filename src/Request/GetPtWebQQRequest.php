<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetPtWebQQRequest extends Request
{
    protected $referer = UrlStore::GET_PTWEBQQ_REFERER;
}
