<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\UrlStore;

class SendDiscusMessageRequest extends Request
{
    protected $url = UrlStore::SEND_MESSAGE_TO_DISCUS;

    protected $referer = UrlStore::SEND_MESSAGE_TO_DISCUS_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;

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
