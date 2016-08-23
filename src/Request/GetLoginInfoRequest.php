<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetLoginInfoRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_LOGIN_INFO;

    protected $referer = UrlStore::GET_LOGIN_INFO_REFERER;
}
