<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class PollMessagesRequest extends AbstractRequest
{
    protected $url = UrlStore::POLL_MESSAGES;

    protected $referer = UrlStore::POLL_MESSAGES_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;
}
