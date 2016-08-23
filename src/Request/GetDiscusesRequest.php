<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetDiscusesRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_DISCUSES;

    protected $referer = UrlStore::GET_DISCUSES_REFERER;
}
