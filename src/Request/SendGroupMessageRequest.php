<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class SendGroupMessageRequest extends AbstractRequest
{
    protected $url = UrlStore::SEND_MESSAGE_TO_GROUP;

    protected $referer = UrlStore::SEND_MESSAGE_TO_GROUP_REFERER;
}