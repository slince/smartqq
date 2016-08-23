<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class SendFriendMessageRequest extends AbstractRequest
{
    protected $url = UrlStore::SEND_MESSAGE_TO_FRIEND;

    protected $referer = UrlStore::SEND_MESSAGE_TO_FRIEND_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;
}
