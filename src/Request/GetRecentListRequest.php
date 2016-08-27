<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Model\Discus;
use Slince\SmartQQ\Model\Member;
use Slince\SmartQQ\Model\Recent;
use Slince\SmartQQ\UrlStore;

class GetRecentListRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_RECENT_LIST;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;

    /**
     * 解析响应数据
     * @param Response $response
     * @return Discus
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $recents = [];
            foreach ($jsonData['result'] as $recent) {
                $recent = new Recent([
                    'type' => $recent['type'],
                    'uin' => $recent['uin'],
                ]);
                $recents[] = new Recent($recent);
            }
            return $recents;
        }
        throw new ResponseException("Response Error");
    }
}
