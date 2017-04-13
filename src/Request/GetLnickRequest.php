<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Collection\Collection;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Friend;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;

class GetLnickRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_single_long_nick2?tuin={uin}&vfwebqq={vfwebqq}&t=0.1';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    public function __construct(Friend $friend, Credential $credential)
    {
        $this->setTokens([
            'uin' => $friend->getUin(),
            'vfwebqq' => $credential->getVfWebQQ()
        ]);
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @param Friend $friend
     * @return int
     */
    public static function parseResponse(Response $response, Friend $friend)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $info = (new Collection($jsonData['result']))->filter(function($info) use($friend){
                return $info['uin'] == $friend->getUin();
            })->first();
            return $info ? $info['lnick'] : null;
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
