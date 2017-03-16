<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class VerifyQrCodeRequest extends AbstractRequest
{
    /**
     * 二维码状态，未失效
     * @var int
     */
    const STATUS_UNEXPIRED = 1;

    /**
     * 二维码状态，已失效
     * @var int
     */
    const STATUS_EXPIRED = 2;

    /**
     * 二维码状态，认证中
     * @var int
     */
    const STATUS_ACCREDITATION = 3;

    /**
     * 二维码状态，认证成功
     * @var int
     */
    const STATUS_CERTIFICATION = 4;

    protected $url = UrlStore::VERIFY_QR_CODE;

    protected $referer = UrlStore::VERIFY_QR_CODE_REFERER;
}
