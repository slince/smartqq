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
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\GroupDetail;
use Slince\SmartQQ\Entity\GroupMember;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Entity\Group;

class GetGroupDetailRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_group_info_ext2?gcode={groupcode}&vfwebqq={vfwebqq}&t=0.1';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    public function __construct(Group $group, Credential $credential)
    {
        $this->setTokens([
            'groupcode' => $group->getCode(),
            'vfwebqq' => $credential->getVfWebQQ(),
        ]);
    }

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return GroupDetail
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && 0 == $jsonData['retcode']) {
            //群成员的vip信息
            $vipInfos = (new Collection($jsonData['result']['vipinfo']))->combine('u', function($entity) {
                return $entity;
            })->toArray();
            //群成员的名片信息
            $cards = (new Collection($jsonData['result']['cards']))->combine('muin', 'card')->toArray();
            //群成员的简要信息
            $flags = (new Collection($jsonData['result']['ginfo']['members']))->combine('muin', 'mflag')
                ->toArray();
            //群基本详细信息
            $groupData = $jsonData['result']['ginfo'];
            $groupDetailData = [
                'gid' => $groupData['gid'],
                'name' => $groupData['name'],
                'code' => $groupData['code'],
                'owner' => $groupData['owner'],
                'level' => $groupData['level'],
                'createTime' => $groupData['createtime'],
                'flag' => $groupData['flag'],
                'memo' => $groupData['memo'],
                'members' => null,
            ];
            $members = [];
            foreach ($jsonData['result']['minfo'] as $memberData) {
                $uin = $memberData['uin'];
                $member = EntityFactory::createEntity(GroupMember::class, [
                    'flag' => isset($flags[$uin]) ? $flags[$uin] : null,
                    'nick' => $memberData['nick'],
                    'province' => $memberData['province'],
                    'gender' => $memberData['gender'],
                    'uin' => $uin,
                    'country' => $memberData['country'],
                    'city' => $memberData['city'],
                    'card' => isset($cards[$uin]) ? $cards[$uin] : null,
                    'isVip' => isset($vipInfos[$uin]) ? $vipInfos[$uin]['is_vip'] == 1 : false,
                    'vipLevel' => isset($vipInfos[$uin]) ? $vipInfos[$uin]['vip_level'] : 0,
                ]);
                $members[] = $member;
            }
            $groupDetailData['members'] = new EntityCollection($members);

            return EntityFactory::createEntity(GroupDetail::class, $groupDetailData);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
