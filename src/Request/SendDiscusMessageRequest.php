<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class SendDiscusMessageRequest extends AbstractRequest
{
    protected $url = UrlStore::SEND_MESSAGE_TO_DISCUS;

    protected $referer = UrlStore::SEND_MESSAGE_TO_DISCUS_REFERER;
}