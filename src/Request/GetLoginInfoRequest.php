<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Model\Birthday;
use Slince\SmartQQ\Model\Profile;
use Slince\SmartQQ\UrlStore;

class GetLoginInfoRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_LOGIN_INFO;

    protected $referer = UrlStore::GET_LOGIN_INFO_REFERER;

    /**
     * 解析响应数据
     * @param Response $response
     * @return Profile
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $profile = new Profile($jsonData['result']);
            $profile->birthday = new Birthday($profile->birthday);
            return $profile;
        }
        throw new ResponseException("Response Error");
    }
}
