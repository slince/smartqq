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

use Cake\Collection\Collection;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Entity\Group;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Utils;

class GetGroupsRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_group_name_list_mask2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', \GuzzleHttp\json_encode([
            'vfwebqq' => $credential->getVfWebQQ(),
            'hash' => Utils::hash($credential->getUin(), $credential->getPtWebQQ()),
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
            $markNames = (new Collection($jsonData['result']['gmarklist']))->combine('uin', 'markname')
                ->toArray();
            $groups = [];
            foreach ($jsonData['result']['gnamelist'] as $groupData) {
                $groupId = $groupData['gid'];
                $groupData['id'] = $groupData['gid'];
                $groupData['markName'] = isset($markNames[$groupId]) ? $markNames[$groupId] : '';
                $group = EntityFactory::createEntity(Group::class, $groupData);
                $groups[] = $group;
            }

            return new EntityCollection($groups);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
