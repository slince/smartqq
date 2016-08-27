<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\Model\OnlineStatus;
use Slince\SmartQQ\UrlStore;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;

class GetFriendsOnlineStatusRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_FRIENDS_ONLINE_STATUS;

    protected $referer = UrlStore::GET_FRIENDS_ONLINE_STATUS_REFERER;


    /**
     * 解析响应数据
     * @param Response $response
     * @return OnlineStatus[]
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $onlineStatuses = [];
            foreach ($jsonData['result'] as $status) {
                $onlineStatuses[] = new OnlineStatus($status);
            }
            return $onlineStatuses;
        }
        throw new ResponseException("Response Error");
    }
}
