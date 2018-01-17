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
use Slince\SmartQQ\Entity\Recent;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;

class GetRecentListRequest extends Request
{
    protected $uri = 'http://d1.web2.qq.com/channel/get_recent_list2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', \GuzzleHttp\json_encode([
            'vfwebqq' => $credential->getVfWebQQ(),
            'clientid' => $credential->getClientId(),
            'psessionid' => $credential->getPSessionId(),
        ]));
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
            $recentList = [];
            foreach ($jsonData['result'] as $recent) {
                $recentList[] = EntityFactory::createEntity(Recent::class, [
                    'type' => $recent['type'],
                    'uin' => $recent['uin'],
                ]);
            }

            return new EntityCollection($recentList);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
