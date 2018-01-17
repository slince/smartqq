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
use Slince\SmartQQ\Entity\OnlineStatus;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;

class GetFriendsOnlineStatusRequest extends Request
{
    protected $uri = 'http://d1.web2.qq.com/channel/get_online_buddies2?vfwebqq={vfwebqq}&clientid=53999199&psessionid={psessionid}&t=0.1';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(Credential $credential)
    {
        $this->setTokens([
            'vfwebqq' => $credential->getVfWebQQ(),
            'psessionid' => $credential->getPSessionId(),
        ]);
    }

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return EntityCollection
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && 0 == $jsonData['retcode']) {
            $onlineStatuses = [];
            foreach ($jsonData['result'] as $status) {
                $onlineStatuses[] = EntityFactory::createEntity(OnlineStatus::class, [
                    'clientType' => $status['client_type'],
                    'uin' => $status['uin'],
                    'status' => $status['status'],
                ]);
            }

            return new EntityCollection($onlineStatuses);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
