<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetQrCodeRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_QR_CODE;

    protected $referer = null;
}