<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Friend;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;

class GetQQRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_friend_uin2?tuin={uin}&type=1&vfwebqq={vfwebqq}&t=0.1';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(Friend $friend, Credential $credential)
    {
        $this->setTokens([
            'uin' => $friend->getUin(),
            'vfwebqq' => $credential->getVfWebQQ(),
        ]);
    }

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return int
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && 0 == $jsonData['retcode']) {
            return $jsonData['result']['account'];
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
