<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetQrCodeRequest extends Request
{
    protected $url = UrlStore::GET_QR_CODE;

    protected $referer = null;
}
