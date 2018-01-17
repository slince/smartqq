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

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Birthday;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\Entity\Profile;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;

class GetFriendDetailRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_friend_info2?tuin={uin}&vfwebqq={vfwebqq}&clientid=53999199&psessionid={psessionid}&t=0.1';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    public function __construct(Friend $friend, Credential $credential)
    {
        $this->setTokens([
            'uin' => $friend->getUin(),
            'vfwebqq' => $credential->getVfWebQQ(),
            'psessionid' => $credential->getPSessionId(),
        ]);
    }

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return Profile
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && 0 == $jsonData['retcode']) {
            $profileData = $jsonData['result'];
            //注意获取好友详情接口并不返回account和lnick
            return EntityFactory::createEntity(Profile::class, [
                'account' => isset($profileData['account']) ? $profileData['account'] : null,
                'lnick' => isset($profileData['lnick']) ? $profileData['lnick'] : null,
                'face' => $profileData['face'],
                'birthday' => Birthday::createFromArray($profileData['birthday']),
                'occupation' => $profileData['occupation'],
                'phone' => $profileData['phone'],
                'allow' => $profileData['allow'],
                'college' => $profileData['college'],
                'uin' => $profileData['uin'],
                'constel' => $profileData['constel'],
                'blood' => $profileData['blood'],
                'homepage' => $profileData['homepage'],
                'stat' => isset($profileData['stat']) ? $profileData['stat'] : null,
                'vipInfo' => $profileData['vip_info'],
                'country' => $profileData['country'],
                'city' => $profileData['city'],
                'personal' => $profileData['personal'],
                'nick' => $profileData['nick'],
                'shengXiao' => $profileData['shengxiao'],
                'email' => $profileData['email'],
                'province' => $profileData['province'],
                'gender' => $profileData['gender'],
                'mobile' => $profileData['mobile'],
            ]);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
