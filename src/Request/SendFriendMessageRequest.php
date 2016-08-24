<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\UrlStore;

class SendFriendMessageRequest extends AbstractRequest
{
    protected $url = UrlStore::SEND_MESSAGE_TO_FRIEND;

    protected $referer = UrlStore::SEND_MESSAGE_TO_FRIEND_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;

    /**
     * @param Response $response
     * @return bool
     */
    function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        return $jsonData && $jsonData['errCode'] === 0;
    }
}
