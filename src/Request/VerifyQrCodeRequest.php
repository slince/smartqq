<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class VerifyQrCodeRequest extends AbstractRequest
{
    protected $url = UrlStore::FETCH_QR_CODE;

    protected $referer
}