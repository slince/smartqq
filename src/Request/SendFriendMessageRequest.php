<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\UrlStore;

class SendFriendMessageRequest extends Request
{
    protected $uri = UrlStore::SEND_MESSAGE_TO_FRIEND;

    protected $referer = UrlStore::SEND_MESSAGE_TO_FRIEND_REFERER;

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    /**
     * @param Response $response
     * @return bool
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        return isset($jsonData['errCode']) && $jsonData['errCode'] === 0;
    }
}
